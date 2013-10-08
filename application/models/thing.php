<?php

class Thing extends Aware
{
	public static $table = 'things';
	public static $timestamps = true;

	public function tags()
	{
		return $this->has_many_and_belongs_to('Tag', 'tag_thing');
	}

	public function links()
	{
		return $this->has_many('Link');
	}

	public static function votes()
	{
		return $this->has_many('Vote');
	}

	public function create_thing()
	{
		$rules = array(
			'name' => 'required|unique:'.self::$table,
			'user_id' => 'required|integer'
		);

		$messages = array(
		    'unique' => 'A thing with this name already exists.'
		);

		$this->name = Input::get('thing_name');
		$this->user_id = 1;//User::current_user_id();

		return $this->save($rules, $messages);
	}

	public static function get_suggestions($text = false, $num = 5)
	{
		if (!empty($text))
			return Thing::where('name', 'like', '%'.$text.'%')->take($num)->get();
		else
			return false;
	}
}
