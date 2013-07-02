<?php

class Link extends Aware
{
    public static $table = 'links';
    public static $timestamps = true;

    public function things()
    {
        return $this->has_many_and_belongs_to('Thing', 'link_thing');
    }

    public function create_link()
    {
        $rules = array(
            'link'  => 'required',
            'thing_id' => 'required|integer|exists:things,id',
            'user_id'   => 'required|integer|exists:users,id'
        );

        $this->link = Input::get('link');
        $this->user_id =    1;//User::current_user_id();

        return $this->save($rules);
    }
}