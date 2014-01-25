<?php

class Game extends Eloquent
{
    protected $table = 'games';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('User')->withPivot('score');
    }

}