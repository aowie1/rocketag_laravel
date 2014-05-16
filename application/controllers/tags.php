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

	public function get_index()
	{
		return View::make('tags.add');
	}

	public function get_show($tag_id = null)
	{
		if (empty($tag_id) || !$tag = Tag::find($tag_id))
		{
			return Response::error('404');
		}

		$top_things = View::make('things.top', array('things' => $tag->top_things()));

		return View::make('tags.single')
			->with('tag', $tag)
			->with('top_things_widget', $top_things);
	}

	public function get_tags($thing = false, $limit = 10, $start_spectrum = -10, $end_spectrum = 10, $is_fact = false)
	{
		if (!empty($thing))
		{
			$result = Thing::get_thing($thing);
//dd($data);
			if (!empty($result))
			{
				//$data['tags_result'] = Thing::find($data['thing_result']->id)->tags()->take($limit)->get();

				$results = DB::table('tags')
					->join('thing_tag', 'tags.id', '=', 'thing_tag.id')
					->join('things', 'thing_tag.id', '=', 'things.id')
					->join('spectrum', 'tags.id', '=', 'spectrum.tag_id')
					->where('things.name', '=', $thing)
					->where('spectrum.value', '>=', $start_spectrum)
					->where('spectrum.value', '<=', $end_spectrum)
					->get(array('tags.name', 'spectrum.value'));
//dd($data);
				if (!empty($results))
				{
					if (Request::ajax())
						return json_decode($results);
					else
						return View::make('tags.results')
							->with('results', $results);
				}
				else
				{
					echo "No results found";
				}
			}
			else
			{
				return View::make('things.form')
					->with($thing);
			}
		}
		return false; //thing wasnt passed
	}

	public function get_attach($thing_id)
	{
		$tag = new Tag();
		$tag->id = 1;
		echo $tag->things()->attach($thing_id);
	}

	public function post_create()
	{
		$tag = new Tag;

		if ($tag->create_tag()) {

			$spectrum_value = Input::get('spectrum');

			// Set the spectrum for this tag if found
			if (isset($spectrum_value)) {
				$spectrum = new Spectrum;
				$spectrum->create_spectrum($tag->id);
			}

			// If the form was submitted via ajax
			if (Request::ajax()) {
				return View::make('tags.result')
					->with('tag', $tag);
			} else {
				$success = 'Your tag was successfully created!';

				// Return to the same page with a success message
		        return View::make('tags.add')
		            ->with('success', $success);
	        }
	    } else {

	    	// Return to the same page with error messages
	        return Redirect::to('/tags')
                ->with_input()
                ->with_errors($tag->errors);
	    }
	}

	public function post_index()
	{
		echo Tag::post_tag();
	}

	public function post_suggestions()
	{
		$tag = Input::get('str');
		$num = Input::get('num');
		$exclude = Input::get('exclude');
		$exact = Input::get('exact');

		if(!empty($tag)) {
			if (!$exact) {
				$tags = Tag::where('name', 'like', '%'.$tag.'%')->where(function($q) use ($exclude) {
					if (!empty($exclude))
						$q->where_not_in('id', $exclude);
				})->take($num)->get();
			} else {
				$tags = Tag::where_name($tag)->get();
			}
		}

// dd($parsed_tags);
		if (!is_null($tags))
			return View::make('tags.suggestions')->with('tags', $tags);
	}
}