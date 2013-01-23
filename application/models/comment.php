<?php

class Comment extends Aware
{
    public static $table = 'comments';
    public static $timestamps = true;

    public function tag_thing()
    {
        return $this->belongs_to('Thing');
    }
}