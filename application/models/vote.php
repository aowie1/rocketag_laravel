<?php

class Vote extends Aware
{
    public function thing()
    {
        return $this->belongs_to('Thing');
    }

    public function users()
    {
        return $this->belongs_to('User');
    }
}