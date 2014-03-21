<?php

class Auth_Controller extends Controller {

    public $restful = TRUE;

    public $user;

    public function __construct()
    {

    }

    public function get_login()
    {
        return View::make('auth.page')->nest('content', 'auth.login.form');
    }

    public function post_login()
    {
        $login = User::try_login();

        if (!empty($login['errors']))
        {
            return Redirect::to('/login')
                ->with_input()
                ->with_errors($login['errors']);
        }

        return Redirect::to('/')->with('success', 'You have logged in successfully!');
    }

    public function get_register()
    { 
        return View::make('auth.page')->nest('content', 'auth.register.form');
    }

    public function post_register()
    {
        $user = new User;

        if ($user->create_user())
        {
            return Redirect::to('/')->with('success', 'Thank you for submitting your registration. Please click on the link sent to your email to verify your account and complete the registration.');
        }
        else
        {
            return Redirect::to('/register')
                ->with_errors($user->errors)
                ->with_input();
        }
    }
}