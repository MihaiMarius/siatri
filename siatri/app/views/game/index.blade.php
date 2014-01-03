@section('headerSettings')
<title>Siatri - Game Lobby</title>
@stop

@section('externalFiles')
<script type="text/javascript" src="js/gamelobby.js" ></script>
@stop
@section('content')
<h1>Welcome {{ isset($username) ? $username : 'Guest' }}!</h1>
<a id="lnkSendInvitation" onclick="postTweet()" class="btn btn-lg btn-primary">Send Invitation</a>
@stop