<?php

class Search_Controller extends Base_Controller {

    public $restful = true;

    public function get_index()
    {
        $data = array();

        $search_str = Input::get('s');

        if (!empty($search_str))
        {
            $data['tags_results'] = Tag::where('name', 'LIKE', '%'.$search_str.'%')->get();

            $data['things_results'] = Thing::where('name', 'LIKE', '%'.$search_str.'%')->get();

            return View::make('search.results', $data);
        }
    }
}