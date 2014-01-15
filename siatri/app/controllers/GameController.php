<?php

class GameController extends BaseController {
    public function lobby( $host ){
        return View::make('game.lobby');
    }
    public function room( $host ){
        return View::make('game.room');
    }
}