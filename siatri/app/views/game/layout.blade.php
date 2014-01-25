@extends('layout')

@section('scripts')
    {{ HTML::script('js/lib/autobahn.min.js') }} 
    <script>
    var chat = (function(){

        var config = {
            host: 'ws://www.siatri.com:8000',
            room: 'game/{{$host}}',
            user: '{{$user}}'
        }, con, exists = false, syncSession = null,

        sendMessage = function(msg, msgType){
            if(typeof(msgType) == 'undefined')
            msgType = "general";
            var payload = {
                mtype: msgType,
                message: msg
            }
            con.publish(config.room, payload);
        },

        listen = function (topic, evt){
            if(topic != config.room) return;
            console.log('received', evt);

            switch( evt.m.mtype ){
                case 'connect':
                    console.log('user '+evt.from+' connected');
                    break;
                default: //simple message
                    console.log(evt.from, 'said');
                    console.log(evt.m.message);
            }
        }

        return { //public interface
            con: con, // this should go in prod
            msg: sendMessage, // this should go in prod
            config: !exists ? config : null,
            init: function(session){
                if(!exists)
                    this.con = con = session;
                else exists = true;
            },
            connected: function(){
                if(exists) return;
                console.log('chat connected');
                syncSession = $.ajax({
                    url: '/game/syncWampSession',
                    type: 'POST',
                    data: {
                        wampSession: con.sessionid(),
                        whoami: config.user
                    }
                }).done(function(){
                    con.subscribe(config.room, listen);
                });
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

@section('menubuttons')
<span class="buttonsContainer">
	<a class="btn btn-success btn-md" role="button" href="/"><i class="fa fa-home fa-lg"></i> <span >Home</span></a>
	<a class="btn btn-success btn-md" role="button" href="/top"><i class="fa fa-list fa-lg"></i> <span >Top 15</span></a>
</span>
@stop