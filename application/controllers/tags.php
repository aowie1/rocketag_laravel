<?php

class Tags_Controller extends Base_Controller
{
	/*
	|--------------------------------------------------------------------------
	| The Tags Controller
	|--------------------------------------------------------------------------
	*/
	public $restful = true;

	public function get_index($name = false)
	{

		$data['result'] = Tag::get_tag($name);
//dd($result);
		if (!empty($data['result']))
			return View::make('tags.result')->with($data);
		else
		{
			$data['tag'] = Input::old('name') ?: ( !empty($name) ? $name : '');

			return View::make('tags.add')->with($data);
		}
	}

	public function get_tags($thing = false, $limit = 10, $start_spectrum = -10, $end_spectrum = 10, $is_fact = false)
	{
		$data['thing_name'] = $thing;

		if (!empty($thing))
		{
			$data['thing_result'] = Thing::get_thing($data['thing_name']);
//dd($data);
			if (!empty($data['thing_result']))
			{
				//$data['tags_result'] = Thing::find($data['thing_result']->id)->tags()->take($limit)->get();

				$data['tag_results'] = DB::table('tags')
					->join('thing_tag', 'tags.id', '=', 'thing_tag.id')
					->join('things', 'thing_tag.id', '=', 'things.id')
					->join('spectrum', 'tags.id', '=', 'spectrum.tag_id')
					->where('things.name', '=', $thing)
					->where('spectrum.value', '>=', $start_spectrum)
					->where('spectrum.value', '<=', $end_spectrum)
					->get(array('tags.name', 'spectrum.value'));
//dd($data);
				if (!empty($data['tag_results']))
				{
					if (isset($_SERVER['X_HTTP_REQUESTED_WITH']))
						return json_decode($data);
					else
						return View::make('tags.results')->with($data);
				}
				else
				{
					echo "No results found";
				}
			}
			else
			{
				return View::make('things.form')->with($data);
			}
		}
		return false; //thing wasnt passed
	}

	public function post_add()
	{
		$tag = new Tag();
		$tag->name = Input::get('name');
		$tag->user_id	=	1;

		echo $tag->save(); //returns 1 = success, 0 = failure
	}

	public function post_index()
	{
		echo Tag::post_tag();
	}

	public function get_suggestions($tag = false, $num = false)
	{
		$data['tag'] = $tag;

		if(empty($num))
			$data['suggestive_results'] = Tag::get_suggestions($tag);
		else
			$data['suggestive_results'] = Tag::get_suggestions($tag, $num);

		if (!empty($data['suggestive_results']))
			return View::make('tags.results')->with($data);
		else
			return View::make('tags.add')->with($data);
	}
}