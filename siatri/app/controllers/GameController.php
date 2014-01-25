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

    public function syncWampSession(){
        if (Request::ajax()){
            $user =  SessionManager::getAuthTwitterUser();
            $user->wampSession = Input::get('wampSession');
            if($user->save())
                return Response::json(array('msg' => 'ok'), 200);
            else
                return Response::json(array('msg' => 'could not save WAMP session; please try again'), 503);
        }
        return Response::json(array('status' => 'error', 'msg' => 'bad request'), 400);
    }
}