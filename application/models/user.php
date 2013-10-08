<?php
/**
 * User Model
 * Notes: Return sentry errors as 'sentry' because it can conflict with the $error for validation.
 * This way we also know the error is from sentry making an attempt at something
 *
 * @author Randen Kelly <aowie1@gmail.com>
 * @since January 10, 2012
 */
class User extends Aware
{
    /**
     * Name of the DB table associated with this model
     */
    public static $table = 'users';

    /**
     * Are standard timestamps(created_at & updated_at) used for this model/table?
     */
    public static $timestamps = true;

    /**
     * Ignore these. We redefine the rules for POST & PUT in their respective method
     * because they are not the same due to the password field being required for one
     * but not the other.
     */
    public static $rules = array();

    /**
     * Constructor
     *
     * @return void
     */
    public function __constructor()
    {
        //
    }

    /**
     * Used to describe the relationship between User & User_Metadata
     *
     * @return relationship
     */
    public function metadata()
    {
        return $this->has_one('User_Metadata');
    }

    /**
     * Used to describe the relationship between Users & Groups
     */
    public function groups()
    {
        return $this->has_many_and_belongs_to('Group', 'users_groups');
    }

    /**
     * Used to describe the relationship between Users & Permissions
     *
     * @return relationship
     */
    public function permissions()
    {
        return $this->has_many_and_belongs_to('Permission', 'user_permissions');
    }

    /**
     * Used to describe the relationship between a User & Comments
     *
     * @return relationship
     */
    public function comments()
    {
        return $this->has_many('Comment');
    }

    /**
     * Used to describe the relationship between a User & Votes
     *
     * @return relationship
     */
    public function votes()
    {
        return $this->has_many('Vote');
    }

    /**
     * Return the currently logged in users id
     *
     * @return integer
     */
    public static function current_user_id()
    {
        return Session::has(Config::get('sentry::sentry.session.user'))
            ? Session::get(Config::get('sentry::sentry.session.user'))
            : 0;
    }

    /**
     * Return the currently logged in user
     *
     * @return User
     */
    public static function current_user()
    {
        if (!IoC::registered('current_user'))
        {
            IoC::singleton('current_user', function()
            {
                $u = User::find(User::current_user_id());
                return $u;
            });
        }

        return IoC::resolve('current_user');
    }

    /**
     * Save information from the edit page to the DB
     *
     * @return boolean was creation successful
     */
    public function create_user($user_data = null)
    {
        $this->username = empty($user_data->username) ? Input::get('username') : $user_data->username;
        $this->email = empty($user_data->email) ? Input::get('email') : $user_data->email;
        $this->password = empty($user_data->password) ? Input::get('password') : $user_data->password;
        $this->password_confirmation = empty($user_data->password) ? Input::get('password_confirmation') : $user_data->password;

        $metadata = new User_Metadata();
        $metadata->first_name = empty($first_name) ? Input::get('first_name') : $first_name;
        $metadata->last_name = empty($last_name) ? Input::get('last_name') : $last_name;

        $rules = array(
            'email'            => 'required|email|unique:users,email',
            'password'        => 'required|confirmed|password:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).+$/|min:'.Config::get('password_min_length'),
        );

        $user_valid = $this->valid($rules);
        $metadata_valid = TRUE; //$metadata->valid($rules);

        if ($user_valid === false || $metadata_valid === false)
        {
            $this->errors->messages = array_merge($this->errors->messages, $metadata->errors->messages);

            return false;
        }
        else
        {
            // Use Sentry to create the user so that our password is hashed properly
            $user_data = Sentry::user()->create(array(
                'username'  => $this->username,
                'email'     => $this->email,
                'password'  => $this->password,
                // 'metadata'    => array(
                //     'first_name'    => $metadata->first_name,
                //     'last_name'     => $metadata->last_name
                // )
            ), Config::get('sentry.activation'));

            $this->user_data = $user_data;

            return true;
        }
    }

    /**
     * Save information from the edit page to the DB
     *
     * @return boolean was saving successful
     */
    public function save_user_and_metadata()
    {
        $this->email = Input::get('email');
        $this->password = Input::get('password');
        $this->password_confirmation = Input::get('password_confirmation');
        $this->metadata->first_name = Input::get('first_name');
        $this->metadata->last_name = Input::get('last_name');

        $rules = array(
            'email'            => 'required|email',
            'password'        => 'confirmed|min:'.Config::get('password_min_length')
        );

        $user_valid = $this->valid($rules);
        $metadata_valid = $this->metadata->valid();

        if ($user_valid === false || $metadata_valid === false)
        {
            $this->errors->messages = array_merge($this->errors->messages, $this->metadata->errors->messages);

            return false;
        }
        else
        {
            // If the password is set, save it
            if ($this->password <> '')
            {
                // We use a Sentry user so that it will hash the password for us.
                $sentry_user = Sentry::user((int)$this->id);
                $sentry_user->update(array('password' => $this->password));
            }

            // Remove password & password_confirmation
            // They need to be in the object for validation but saving will fail if they exist.
            unset($this->attributes['password']);
            unset($this->attributes['password_confirmation']);

            // Save the User object
            $this->save();

            // Save the users Metadata object
            $this->metadata->save();

            // Get all groups & generate an array of group id's that were checked
            $groups = Group::all();
            $checked_arr = array();
            foreach ($groups as $group)
            {
                $checked = (int)Input::get('group_'.$group->id);
                if ($checked)
                {
                    array_push($checked_arr, $group->id);
                }
            }
            $this->groups()->sync($checked_arr);

            // Get all permissions & generate an array of permission id's that were checked
            $permissions = Permission::all();
            $checked_arr = array();
            foreach ($permissions as $permission)
            {
                $checked = (int)Input::get('permission_'.$permission->id);
                if ($checked)
                {
                    array_push($checked_arr, $permission->id);
                }
            }
            $this->permissions()->sync($checked_arr);

            return true;
        }
    }

    /**
     * Try to log the user in and return errors
     *
     * @return array:mixed
     */
    public static function try_login()
    {
        try
        {
            $valid_login = Sentry::login(Input::get('username'), Input::get('password'), Input::get('remember'));

            return ($valid_login)
                ?: $data = array('errors' => __('auth.login.failed'));
        }
        catch (Sentry\SentryException $e)
        {
            // issue logging in via Sentry - lets catch the sentry error thrown
            // store/set and display caught exceptions such as a suspended user with limit attempts feature.
            $errors = $e->getMessage();
            return $data = array('errors' => $errors);
        }
    }

    /**
     * Try to register the user and return errors
     *
     * @param array:mixed
     * @param boolean
     * @return array:mixed
     */
    public static function try_registration($vars, $activation)
    {
        try
        {
            // If activation is required an array is returned, otherwise just the user_id integer
            $user_return = Sentry::user()->create($vars, $activation);
            $user_id = 0;
            $hash = '';
            if (is_array($user_return))
            {
                $user_id = $user_return['id'];
                $hash = isset($user_return['hash']) ? $user_return['hash'] : '';
            }
            else
            {
                $user_id = $user_return;
                $hash = '';
            }

            if ($user_id)
            {
                return $data = array(
                    'success'    => true,
                    'user_id'    => $user_id,
                    'hash'        => $hash
                );
            }
            else
            {
                // something went wrong - shouldn't really happen
                return $data = array('success' => false, 'sentry' => 'The system encountered a major error.');
            }
        }
        catch (Sentry\SentryException $e)
        {
            $errors = $e->getMessage(); // catch errors such as user exists or bad fields
            return $data = array('success' => false, 'sentry' => $errors);
        }
    }

    /**
     * Check if the user is logged in
     *
     * @return bool
     */
    public static function is_logged_in()
    {
        return Sentry::check();
    }

    /**
     * Force log the user in based on their ID
     *
     * @param integer $user_id
     * @return void
     */
    public static function force_login($user_id)
    {
        Sentry::force_login($user_id);
    }

    /**
     * Log a user out and redirect to the login page
     *
     * @return void
     */
    public static function logout()
    {
        Sentry::logout();
        return Redirect::to('login')->with('logout', 'You are now logged out!');
    }

    /**
     * Get the user with id equal to $id.
     * If the user is the current user, use the IoC container to retrieve them.
     *
     * @param integer $id
     * @return User
     */
    public static function get_user($id)
    {
        $user = User::current_user();
        if ($id != $user->id)
        {
            $user = User::find($id);
        }

        return $user;
    }

    /**
     * Is the given user in the admin group?
     *
     * @param User $user defaults to null which causes the method to check the currently logged in user
     * @return boolean
     */
    public static function is_admin($user = null)
    {
        // If no user is passed in, use the current user
        $user = is_null($user) ? User::current_user() : $user;

        return in_array('Admin', $user->groups()->lists('name'));
    }
}
