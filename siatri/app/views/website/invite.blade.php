@extends('website.layout')
@section('title')
    Siatri - Game Invitation Screen
@stop
@section('scripts')
    {{ HTML::script('js/gamelobby.js') }}
@stop

@section('content')
    <h1>Welcome {{ isset($username) ? $username : 'Guest' }}!</h1>
    <a id="lnkSendInvitation" onclick="postTweet()" class="btn btn-lg btn-primary">Send Invitation</a>
@stop