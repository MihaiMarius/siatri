@extends('layout')

@section('styles')
{{ HTML::style('css/game.css') }}
@stop

@section('scripts')
    {{ HTML::script('js/lib/autobahn.min.js') }} 
    <script>
    var chat = (function(){

        var config = {
            host: 'ws://www.siatri.com:8000',
            room: 'game/{{$host}}',
            user: '{{$user}}'
        }, con, exists = false, syncSession = null,

        sendMessage = function(msg){
            return msg && !(/^\s+$/.test(msg)) && con.publish(config.room, msg) || true;
        },

        listen = function (topic, evt){
            if(topic != config.room) return;
            if(evt.from == config.user && evt.type == "general" ) evt.type = "mine";
            switch( evt.type ){
                case 'status':
                    console.log("status update", evt.msg.users);
                    break;
                case 'connect':
                    evt.msg = 'User '+evt.from+' connected.'
                    evt.from = 'System';
                    break;
                case 'general': //simple message
                    // console.log(evt.from, 'said');
                    // console.log(evt.msg);
            }

            if(evt.type!="status") writeMessage(evt);

        },
        writeMessage = function(evt){
            var type = {
                "connect" : "panel-success",
                "general" : "panel-info",
                "disconnected": "panel-danger",
                "mine" : 'panel-primary'
            },
            body = '<div class="panel '+type[evt.type]+'">\
                      <div class="panel-heading ">'+evt.from+'<span class="pull-right">5:24:20</span></div>\
                      <div class="panel-body">'+
                       evt.msg
                      +'</div>\
                    </div>',
            $log = $('#log');
            $log.append($(body));
            chat.autoscroll ?
            $log[0].scrollTop = $log[0].scrollHeight:null;
        };

        $(function(){
            var $send  = $('#send'),
                $input = $('#input'),
                $lock = $('#lock');

            $send.on('click', function(){
                sendMessage($input.val(), "general") && $input.val('');
            });

            $input.on('keyup', function(e){
                e.which == 13 && sendMessage($(this).val(), "general") && $(this).val('');
            });

            $lock.on('click', function(){
                if(chat.autoscroll){
                    chat.autoscroll = false;
                    $(this).removeClass('active');
                }
                else{
                    chat.autoscroll = true;
                    $(this).addClass('active');
                }
            })
        });


        return { //public interface
            config: !exists ? config : null,
            autoscroll: true,
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