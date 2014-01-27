<?php

class Game extends Eloquent
{
    protected $table = 'games';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('User')->withPivot('score', 'isHost');
    }

    public function host(){
        $user_playing_that_game = $this->users;
        foreach ($user_playing_that_game as $ouser) {
            if($ouser->pivot->isHost){
                return $ouser->username;
            }
        }
        return null;
    }

}