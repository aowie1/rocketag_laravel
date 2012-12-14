<?php
/*
	|--------------------------------------------------------------------------
	| The Tags Controller
	|--------------------------------------------------------------------------
	*/
class Tags_Controller extends Base_Controller
{
	public $restful = true;
	public $layout = 'layouts.master';

	public function get_index($name = false)
	{

		$result = Tag::where('name', '=', $name)->first();

		if (!is_null($result))
			return View::make('tags.single')->with('result', $result);
		else
		{
			$tag = Input::old('name') ?: ( !empty($name) ? $name : '');

			return View::make('tags.add')->with('tag', $tag);
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

				$data['results'] = DB::table('tags')
					->join('thing_tag', 'tags.id', '=', 'thing_tag.id')
					->join('things', 'thing_tag.id', '=', 'things.id')
					->join('spectrum', 'tags.id', '=', 'spectrum.tag_id')
					->where('things.name', '=', $thing)
					->where('spectrum.value', '>=', $start_spectrum)
					->where('spectrum.value', '<=', $end_spectrum)
					->get(array('tags.name', 'spectrum.value'));
//dd($data);
				if (!empty($data['results']))
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

	public function post_create()
	{
		dd('blah');
		$tag = save_tag();
		echo $tag;
	}

	public function post_index()
	{
		echo Tag::post_tag();
	}

	public function get_suggestions($tag = false, $num = false)
	{
		if(empty($num))
			$suggestions = Tag::get_suggestions($tag);
		else
			$suggestions = Tag::get_suggestions($tag, $num);
dd($suggestions);
		if (!is_null($suggestions))
			return View::make('tags.suggestions')->with('suggestions', $suggestions);
	}
}