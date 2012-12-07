<?php

class Things_Controller extends Base_Controller
{
	/*
	|--------------------------------------------------------------------------
	| The Things Controller
	|--------------------------------------------------------------------------
	*/
	public $restful = true;

	public function get_index($name = false)
	{

		$data['result'] = Thing::get_thing($name);
//dd($result);
		if (!empty($data['result']))
			return View::make('things.result')->with($data);
		else
		{
			$data['input_name'] = Input::old('name') ?: ( !empty($name) ? $name : '');

			return View::make('things.add')->with($data);
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
			$data['suggestive_results'] = Thing::get_suggestions($thing);
		else
			$data['suggestive_results'] = Thing::get_suggestions($thing, $num);

		if (!empty($data['suggestive_results']))
			return View::make('things.results')->with($data);
		else
			return View::make('things.add')->with($data);
	}
}