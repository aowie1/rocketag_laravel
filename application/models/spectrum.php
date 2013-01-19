<?php

class Spectrum extends Aware
{
	public static $table = 'spectrum';
	public static $timestamps = true;

	public function tags()
	{
        return $this->belongs_to('Tag');
	}

    public function create_spectrum($tag_id)
    {
        $rules = array(
            'value' => 'required|numeric',
            'user_id'    => 'required|integer',
            'tag_id'    => 'required|integer'
        );

        $this->value = Input::get('spectrum');
        $this->user_id =    1;//User::current_user_id();
        $this->tag_id = $tag_id;

        $this->save($rules);
    }
}
