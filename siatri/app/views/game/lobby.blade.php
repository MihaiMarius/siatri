@extends('game.layout')

@section('title')
    Siatri - Game Lobby
@stop

@section('content')

    <div class="well" id="question">
        Game hasn't started yet. Waiting for players...
    </div>
    <div class="row-fluid clearfix">
        <div class="col-xs-9" id="chat">
            <div class="well">
                
                <div id="log">
                    <!-- <div class="panel panel-success">
                      <div class="panel-heading ">System <span class="pull-right">5:24:20</span></div>
                      <div class="panel-body">
                        User Tiby connected.   
                      </div>
                    </div>
                    
                    <div class="panel panel-info">
                      <div class="panel-heading ">Tiby <span class="pull-right">5:25:13</span></div>
                      <div class="panel-body">
                        hey guys how are you?   
                      </div>
                    </div> -->
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
        <div class="col-xs-3 "id="sidebar">
            <div class="panel panel-default">
              <div class="panel-heading"><span class="badge">1</span> Connected users</div>
              <ul class="list-group">
                <!-- li.list-group-item{User$}*5 -->
                    <li class="list-group-item" id="{{$user}}">
                      @if ($user == $host) <span class="badge">host</span> @endif
                      {{$user}} 
                      
                    </li>
              </ul>
            </div>
        </div>
    </div>
@stop