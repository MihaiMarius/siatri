<?php

class Pusher extends BaseController{
    public function push($msg){
        return var_export(Latchet::publish('room/tiby', array('msg' => $msg)), true);
    }
}