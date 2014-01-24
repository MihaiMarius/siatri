<?php

class GameController extends BaseController {
    public function lobby( $host ){
        return View::make('game.lobby')->with(array(
            'host' => $host,
            'user' => Session::get('user'))
        );
    }
    public function room( $host ){
        return View::make('game.room');
    }
}