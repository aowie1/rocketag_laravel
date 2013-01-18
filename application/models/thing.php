<?php

class Thing extends Aware
{
	public static $table = 'things';
	public static $timestamps = true;

	public function tags()
	{
		return $this->has_many_and_belongs_to('Tag', 'tag_thing');
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

	public function create_thing()
	{
		$rules = array(
			'name' => 'required|unique:'.Static::$table,
			'user_id' => 'required|integer'
		);

		$this->name = Input::get('name');
		$this->user_id =	1;//User::current_user_id();

		return $this->save($rules);
	}

	public function update_thing()
	{
		$rules = array(
			'name' => 'required|unique:'.Static::$table,
			'user_id' => 'required|integer'
		);

		$this->name = Input::get('name');
		$this->user_id =	1;//User::current_user_id();

		return $this->save($rules);
	}

	public static function get_suggestions($text = false, $num = 5)
	{
		if (!empty($text))
			return Thing::where('name', 'like', '%'.$text.'%')->take($num)->get();
		else
			return false;
	}
}
