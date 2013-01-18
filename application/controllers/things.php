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
		return View::make('things.add');
	}

	public function post_create()
	{
		$thing = new Thing;

		$tags = Input::get('tags');

		if ($thing->create_thing()) {

			if (!empty($tags)) {
				$tag_ids = array_keys($tags);
				$thing->tags()->sync($tag_ids);
			}

			$success = 'Your thing was successfully created!';

			// Return to the same page with a success message
	        return View::make('things.add')
	            ->with('success', $success);
	    } else {
	    	$old_tags = (!empty($tags)) ? $tags : false;
// dd($old_tags);
	    	// Return to the same page with error messages
	        return Redirect::to('/things')
	        	->with('old_tags', $old_tags)
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

	public function post_add()
	{
		$thing = new Thing();
		$thing->name = Input::get('name');
		$thing->user_id	=	1;

		echo $thing->save(); //returns 1 = success, 0 = failure
	}

	public function post_index()
	{
		echo Thing::post_thing();
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