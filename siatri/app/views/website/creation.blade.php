@extends('website.layout')
@section('title')
Siatri - Game Invitation Screen
@stop

@section('styles')
{{ HTML::style('css/gamecreation.css') }}
@stop

@section('scripts')
{{ HTML::script('js/gamecreation.js') }}
@stop

@section('content')
<div class='welcome'>
	<h1>Welcome {{ isset($username) ? $username : 'Guest' }}!</h1>
	<a id="lnkSendInvitation" onclick="postTweet()" class="btn btn-lg btn-primary">Create Game</a>
</div>

<div class="panel panel-success game-creation-panel-friends">
	<div class="panel-heading">Invite  Players</div>
	<div class="panel-body">
		Invite players to play with you by simply clicking the row
	</div>

	<!-- Table -->
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Player Name</th>
			</tr>
		</thead>
		<tbody>
			<tr class="primary">
				<td>
					<div>
						<span class="user-profile-img"><img src="/img/user.png"></span>
						<span>Marius Mihai</span>
					</div>
				</td>			
			</tr>
			<tr>
				<td>
					<div>
						<span class="user-profile-img"><img src="/img/user.png"></span>
						<span>Marius Mihai</span>
					</div>
				</td>			
			</tr>
			<tr>
				<td>
					<div>
						<span class="user-profile-img"><img src="/img/user.png"></span>
						<span>Marius Mihai</span>
					</div>
				</td>			
			</tr>
			<tr>
				<td>
					<div>
						<span class="user-profile-img"><img src="/img/user.png"></span>
						<span>Marius Mihai</span>
					</div>
				</td>			
			</tr>
			<tr>
				<td>
					<div>
						<span class="user-profile-img"><img src="/img/user.png"></span>
						<span>Marius Mihai</span>
					</div>
				</td>			
			</tr>	
		</tbody>
	</table>
</div>
@stop

