<?php

class Tag_Thing extends Aware
{
    public static $table = 'tag_thing';
    public static $timestamps = true;

    public function things()
    {
        return $this->belongs_to('Thing', 'thing_id');
    }

    public function tags()
    {
        return $this->belongs_to('Tag', 'tag_id');
    }
}
