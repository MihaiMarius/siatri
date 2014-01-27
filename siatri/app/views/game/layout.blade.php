@extends('layout')

@section('styles')
{{ HTML::style('css/game.css') }}
@stop

@section('scripts')
    {{ HTML::script('js/lib/autobahn.min.js') }} 
    <script>
    var chat = (function(){

        var config = {
            URL: 'ws://www.siatri.com:8000',
            room: 'game/{{$host}}',
            user: '{{$user}}',
            host: '{{$host}}',
            delay: 10
        }, con, exists = false, syncSession = null,

        sendMessage = function(msg){
            return msg && !(/^\s+$/.test(msg)) && con.publish(config.room, msg) || true;
        },

        listen = function (topic, evt){
            if(topic != config.room) return;
            if(evt.from == config.user && evt.type == "general" ) evt.type = "mine";
            switch( evt.type ){
                case 'status':
                    // console.log("status update", evt.msg.users);
                    updateStatus(evt.msg.users);
                    break;
                case 'connect':
                    evt.msg = 'User '+evt.from+' connected.'
                    if( evt.from != config.user) writeUser(evt.from);
                    evt.from = 'System';
                    break;
                case 'disconnect':
                    if(evt.from != config.host)
                        evt.msg = 'User '+evt.from+' disconnected.';
                    else evt.msg = 'Host '+evt.from+' disconnected.';
                    eraseUser(evt.from);
                    evt.from = 'System';
                    break;
                case 'general': //simple message
                    if(evt.msg == "/start" && evt.from == config.host)
                        startGame();
                    break;
                    // console.log(evt.from, 'said');
                    // console.log(evt.msg);
                case 'answer':
                    evt.msg = "correct! " +evt.from + " gets 10 points";
                    evt.from = 'System';
                    break;
                case 'question':
                    writeQuestion(evt.msg);

            }

            if(evt.type!="status"  &&  evt.type != "question" ) writeMessage(evt);

        },
        writeMessage = function(evt){
            var type = {
                "connect" : "panel-success",
                "disconnect" : "panel-danger",
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
        },
        updateStatus = function(users){
            for (u in users){
                writeUser(users[u]);
            }
        },
        writeUser = function(user){
            var $userList = $('#sidebar ul'),
                maybeHostMarkup = user == config.host ? '<span class="badge">host</span>' : /*user == config.user?
                                                        '<span class="badge">you</span>'  : */ '';
                userMarkup = '<li class="list-group-item" id="'+user+'">'
                                + maybeHostMarkup + user +  '</li>';
            $userList.append($(userMarkup));
        },
        eraseUser = function(userName){
            $('#'+userName).remove();
        },
        timer = null;
        window.getNextQuestion = function(){
            console.log("getting newxt question");
            sendMessage('/nextQuestion');
            timer = setTimeout(window.getNextQuestion, 1000 * config.delay);
        };
        var startGame = function(){
            timer = setTimeout(window.getNextQuestion, 1000 * config.delay);
            sendMessage('/gameStart');
        },
        writeQuestion = function(q){
            $('#question').html(q);
        }

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
                    $('#log')[0].scrollTop = $('#log')[0].scrollHeight;
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
    chat.init(new ab.Session( chat.config.URL, chat.connected, chat.disconnected, {'skipSubprotocolCheck': true } ))
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