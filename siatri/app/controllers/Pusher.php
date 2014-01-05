<?php

class Pusher extends BaseController{
    public function push($msg){
        phpinfo(); die();
        Latchet::publish('room/tiby', array('msg' => $msg));
    }
}