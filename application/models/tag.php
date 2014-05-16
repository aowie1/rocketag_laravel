<?php

class Tag extends Aware
{
	public static $table = 'tags';
	public static $timestamps = true;

	public function things()
	{
		return $this->has_many_and_belongs_to('Thing', 'tag_thing');
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

	public function create_tag()
	{
		$rules = array(
			'name' => 'required|unique:'.Static::$table,
			'user_id' => 'required|integer'
		);

		$this->name = Input::get('tag_name');
		$this->slug = Str::slug($this->name);
		$this->user_id =	1;//User::current_user_id();

		return $this->save($rules);
	}

	public function save_tag()
	{
		$rules = array(
			'name' => 'required|unique:'.Static::$table,
			'user_id' => 'required|integer'
		);

		$this->name = Input::get('name');
		$this->user_id =	1;//User::current_user_id();

		return $this->save($rules);
	}

	public static function top_tags($num = 5)
	{
		return Tag::order_by('active_count', 'desc')->where('active_count', '>', 0)->take($num)->get();
	}

	public function top_things($num = 10)
	{
		return $this->things()->order_by('votes', 'desc')->take($num)->get();
	}

	public function get_internal_link()
	{
		return '/tag/'.$this->id;
	}
}
