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

	public function check_slug($slug)
	{
		return self::where_slug($slug)->first();
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


		// Convert the name to a slug
		$slug = Str::slug(Input::get('thing_name'));

		// Check to make sure the slug is unique
		// If not, increment the tail
		$i = 0;
		while (!is_null($this->check_slug($slug)))
		{
		       $slug = $slug.'-'.$i;
		       $i++;
		}

		$this->name = Input::get('thing_name');
		$this->slug = $slug;
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
