<?php
/*
|--------------------------------------------------------------------------
| The Things Controller
|--------------------------------------------------------------------------
*/
class Things_Controller extends Base_Controller
{
	public $restful = true;

	public $thing;

	public function __construct()
	{
		if (!User::is_logged_in())
		{
			$this->user_data = User::current_user();
		}

		// We can always assume the first parameter is a thing id
		$route = Request::route();
		if (!empty($route->parameters[0]))
		{
			$thing_id = $route->parameters[0];

			if (!$this->thing = Thing::with(array('tags', 'links'))->find($thing_id))
			{
				die(Response::error('404'));
			}

			View::share('thing', $this->thing);
		}
	}

	public function get_index()
	{
		$old_tags = Input::old('tags');

		if (!empty($old_tags)) {
			$tag_ids = array_keys($old_tags);

			$tags = Tag::where_in('id', $tag_ids)->get();
		} else {
			$tags = false;
		}

		return View::make('things.add')
			->with('tags', $tags);
	}

	public function post_create()
	{
		$this->thing = new Thing;

		// $tags = Input::get('tags');

		if ($this->thing->create_thing()) {
			// if (!empty($tags)) {
			// 	$tag_ids = array_keys($tags);

			// 	$static_vals = array(
			// 		'user_id' => 1 //User::current_user_id();
			// 	);

			// 	Utility::sync_with_static($thing, 'tags', $tag_ids, $static_vals);
			// }

			$success = 'Your thing was successfully created!';

			// Return to the same page with a success message
	        return Redirect::to('/thing/'.$this->thing->id)
	            ->with('success', $success);
	    } else {
	    	// Return to the same page with error messages
	        return Redirect::to('/thing')
                ->with_input()
                ->with_errors($this->thing->errors);
	    }
	}

	public function get_things($thing = false, $limit = 10, $start_spectrum = -10, $end_spectrum = 10, $is_fact = false)
	{
		$data['things_result'] = Thing::get_things_by_thing($thing_id, $limit, $start_spectrum, $end_spectrum, $is_fact);

		if (!empty($data['result']))
			echo "blah";
		else
			echo "No results found";
	}

	public function get_show()
	{
		$view = View::make('things.single');

		if (!empty($this->user_data))
		{
			$user_data = new StdClass;
			$user_data->vote = $this->user->get_vote($this->thing);

			$view->with('user_data', $user_data);
		}

		if (!is_null($this->thing)) {
			return $view;
				
		} else {
			return Response::error('404');
		}
	}

	public function get_suggestions($thing = false, $num = false)
	{
		if (empty($num))
			$suggestions = Thing::get_suggestions($thing);
		else
			$suggestions = Thing::get_suggestions($thing, $num);

		if (!empty($suggestions))
			return View::make('things.suggestions')->with($suggestions);
	}

	public function put_update($thing_id)
	{
		$status_arr = array();

		if (Input::has('tags'))
		{
			$tag_ids = Input::get('tags');

			$thing->tags()->sync($tag_ids);
		}

        // Redirect to the edit page with a message that says saving was successful
        return Redirect::to(Request::uri())
            ->with('success', 'Thing saved successfully.');
	}

	public function post_vote($value)
	{
		if ($this->user)
		{
			$vote = new Vote;
			$vote->user_id = $this->user->id;
			$vote->thing_id = $this->thing->id;
			$vote->value = (int) $value;
			$vote->save();

			$this->user->attach($vote);

			return Response::json(array('message', 'Thank you for your vote.'));
		}
		else
		{
			return Response::json(array('error', 'An error occur while attempting to cast your vote.'));
		}

		return $view;
	}
}