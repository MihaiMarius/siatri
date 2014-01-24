@extends('layout')

@section('scripts')
    {{ HTML::script('js/lib/autobahn.min.js') }} 
    <script>
    var chat = (function(){

        var config = {
            host: 'ws://www.siatri.com:8000',
            room: 'game/{{$host}}',
            user: '{{$user}}'
        }, con, exists = false,

        sendMessage = function(msg, msgType){
            if(typeof(msgType) == 'undefined')
            msgType = "general";
            var payload = {
                mtype: msgType,
                message: msg,
                from: config.user
            }
            con.publish(config.room, payload);
        },

        listen = function (topic, evt){
            if(topic != config.room) return;
            console.log('received', evt);

            switch( evt.msg.mtype ){
                case 'connect':
                    console.log('user '+evt.msg.from+' connected');
                    break;
                default: //simple message
                    console.log(evt.msg.from, 'said');
                    console.log(evt.msg.message);
            }
        }

        return {
            con: con,
            msg: sendMessage,
            config: !exists ? config : null,
            init: function(session){
                if(!exists)
                    con = session;
                else exists = true;
            },
            connected: function(){
                if(exists) return;
                console.log('chat connected');
                con.subscribe(config.room, listen);
                sendMessage(config.user, 'connect')
            },
            disconnected: function(code){
                if(exists) return;
                console.log('chat disconnected', code);
            } 
        }
    })();
    chat.init(new ab.Session( chat.config.host, chat.connected, chat.disconnected, {'skipSubprotocolCheck': true } ))
    </script>
@stop

@section('title')
    Siatri - Game Area
@stop