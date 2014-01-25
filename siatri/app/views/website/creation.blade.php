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
<div class="game-creation-container">
<div class='welcome'>
	<h1>Welcome {{ isset($username) ? $username : 'Guest' }}!</h1>
	<a id="lnkSendInvitation" onclick="postTweet()" class="btn btn-lg btn-primary">Create Game</a>
	<hr>
	<h4>Game History</h4>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Host</th>
				<th>Score</th>
				<th>Duration</th>
				<th>Start Time</th>
				<th></th>
			</tr>
		</thead>
		<tbod>
			<tr>
				<td>Gigi</td>
				<td>100</td>
				<td>30 minute</td>
				<td>25/12/2020</td>
				<td><a href="#">View OtherPlayers</a></td>
			</tr>
			<tr>
				<td>Gigi</td>
				<td>100</td>
				<td>30 minute</td>
				<td>25/12/2020</td>
				<td><a href="#">View OtherPlayers</a></td>
			</tr>
			<tr>
				<td>Gigi</td>
				<td>100</td>
				<td>30 minute</td>
				<td>25/12/2020</td>
				<td><a href="#">View OtherPlayers</a></td>
			</tr>
			<tr>
				<td>Gigi</td>
				<td>100</td>
				<td>30 minute</td>
				<td>25/12/2020</td>
				<td><a href="#">View OtherPlayers</a></td>
			</tr>
			<tr>
				<td>Gigi</td>
				<td>100</td>
				<td>30 minute</td>
				<td>25/12/2020</td>
				<td><a href="#">View OtherPlayers</a></td>
			</tr>
			<tr>
				<td>Gigi</td>
				<td>100</td>
				<td>30 minute</td>
				<td>25/12/2020</td>
				<td><a href="#">View OtherPlayers</a></td>
			</tr>
		</tbod>
	</table>
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
						<span class="button-checkbox">
							<button type="button" class="btn btn-default" data-color="info">
								<i class="fa fa-square-o"></i><span> Not Invited</span>
							</button>
							<input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
						</span>
					</div>
				</td>			
			</tr>
			<tr>
				<td>
					<div>
						<span class="user-profile-img"><img src="/img/user.png"></span>
						<span>Marius Mihai</span>
						<span class="button-checkbox">
							<button type="button" class="btn btn-success" data-color="info">
								<i class="fa fa-check-square-o"></i><span> Invite</span>
							</button>
							<input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
						</span>
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

