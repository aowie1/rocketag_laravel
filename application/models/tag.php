<?php

class Tag extends Eloquent
{
	public static $table = 'tags';
	public static $timestamps = true;

	public function things()
	{
		$data['things'] = $this->has_many_and_belongs_to('Thing');

	}

	public function spectrum()
	{
		return $this->has_many('spectrum');
	}

	public static function get_all()
	{
		return Tag::order_by('name', 'asc')->get();
	}

	public static function get_tag($name = false)
	{
		return Tag::where('name', '=', $name)->get();
	}

	public static function get_tags_by_thing()
	{
		dd(func_get_args());
	}

	public static function save_tag()
	{
		$tag = new Tag();
		$tag->name = Input::get('name');
		$tag->user_id	=	1;

		return $tag->save(); //returns 1 = success, 0 = failure
	}

	public static function get_suggestions($text = false, $num = 5)
	{
		if (!empty($text))
			return Tag::where('name', 'like', '%'.$text.'%')->take($num)->get();
		else
			return false;
	}
}
