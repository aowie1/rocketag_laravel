<?php

class Thing extends Eloquent
{
	public static $table = 'things';
	public static $timestamps = true;

	public function tags()
	{
		return $this->has_many_and_belongs_to('Tag', 'thing_tag')->with('user_id')->with('originator')->with('anonymous');
	}

	public static function get_all()
	{
		return Thing::order_by('name', 'asc')->get();
	}

	public static function get_thing($name)
	{
		return Thing::where('name', '=', $name)->first();
	}

	public static function get_things_by_thing()
	{
		dd(func_get_args());
	}

	public static function insert()
	{
		$data['name'] 		= 	Input::get('name');
		$data['user_id']	=	1;
		//dd($data);
		Thing::create($data);

		return 'success!';
	}

	public static function get_suggestions($text = false, $num = 5)
	{
		if (!empty($text))
			return Thing::where('name', 'like', '%'.$text.'%')->take($num)->get();
		else
			return false;
	}
}
