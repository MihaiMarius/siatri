@extends('game.layout')

@section('title')
    Siatri - Game Lobby
@stop

@section('content')

    <div class="well" id="question">
        Game hasn't started yet. Waiting for players...
    </div>
    <div class="row-fluid clearfix">
        <div class="col-sm-9" id="chat">
            <div class="well">
                
                <div id="log">

                </div>

                <div class="input-group" id="user-input">
                    <span class="input-group-btn">
                        <span class="btn btn-default active" id="lock">
                             &nbsp;<i class="fa fa-lock"></i>&nbsp;
                        </span>
                    </span>
                    <input type="text" class="form-control" id="input">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="send">Write</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-3 "id="sidebar">
            <div class="panel panel-default">
              <div class="panel-heading"><span class="badge">1</span> Connected users</div>
              <ul class="list-group">
                  <li class="list-group-item" id="{{$user}}">
                    @if ($user == $host) <span class="badge">host</span> @endif
                    {{$user}} 
                  </li>
              </ul>
            </div>
        </div>
    </div>
@stop