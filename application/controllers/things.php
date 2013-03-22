<?php

class Things_Controller extends Base_Controller
{
	/*
	|--------------------------------------------------------------------------
	| The Things Controller
	|--------------------------------------------------------------------------
	*/
	public $restful = true;

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
		$thing = new Thing;

		// $tags = Input::get('tags');

		if ($thing->create_thing()) {

			// if (!empty($tags)) {
			// 	$tag_ids = array_keys($tags);

			// 	$static_vals = array(
			// 		'user_id' => 1 //User::current_user_id();
			// 	);

			// 	Utility::sync_with_static($thing, 'tags', $tag_ids, $static_vals);
			// }

			$success = 'Your thing was successfully created!';

			// Return to the same page with a success message
	        return Redirect::to('/thing/'.$thing->name)
	            ->with('success', $success);
	    } else {
	    	$old_tags = !empty($tags) ? $tags : false;
 // dd($old_tags);
	    	// Return to the same page with error messages
	        return Redirect::to('/thing')
                ->with_input()
                ->with_errors($thing->errors);
	    }
	}

	public function get_things($thing = false, $limit = 10, $start_spectrum = -10, $end_spectrum = 10, $is_fact = false)
	{
		$data['thing_result'] = Thing::get_thing($thing);

		$data['things_result'] = Thing::get_things_by_thing($thing_id, $limit, $start_spectrum, $end_spectrum, $is_fact);

		if (!empty($data['result']))
			echo "blah";
		else
			echo "No results found";
	}

	public function get_show($thing_slug)
	{
		$thing = Thing::with('tags')->where_slug($thing_slug)->first();

		if (!is_null($thing)) {
			return View::make('things.single')
				->with('thing', $thing);
		} else {
			return Response::error('404');
		}
	}

	public function get_suggestions($thing = false, $num = false)
	{
		if(empty($num))
			$suggestions = Thing::get_suggestions($thing);
		else
			$suggestions = Thing::get_suggestions($thing, $num);

		if (!empty($suggestions))
			return View::make('things.suggestions')->with($suggestions);
	}
}