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
<div  data-bind="with: $data" class="game-creation-container">
	<div  class='welcome'>
		<div data-bind="with:host">
			<h1>Welcome {{ isset($username) ? $username : 'Guest' }}!</h1>
			<span class="welcome-user-details">
				<span>Current Score</span>&nbsp;<span data-bind="text: score" class="points">200</span> points
			</span>
		</div>
		<div>
			<a id="lnkSendInvitation" onclick="postTweet()" class="btn btn-lg btn-primary">Create Game</a>
		</div>
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
			<tbody data-bind="foreach: gameHistory">
				<tr>
					<td data-bind="text: hostName"></td>
					<td data-bind="text: gameno"></td>
					<td data-bind="text: score"></td>
					<td data-bind="text: startDate"></td>
					<td><button data-bind="click: viewOtherPlayers"  class="btn btn-link btn-xs" data-toggle="modal" data-target="#otherPlayersModal">
						Other Players
					</button></td>
				</tr>
			</tbody>
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
					<th>Player Name <input data-bind="value: searchedFriendName, valueUpdate: 'afterkeydown'" class="form-control filter-friend"type="text"/>	</th>
				</tr>
			</thead>
			<tbody data-bind="foreach:filteredFriedList">
				<tr class="primary">
					<td>
						<div>
							<span class="user-profile-img"><img data-bind="attr : {'src' : profileImageSrc}"></span>
							<span><a data-bind="text: username,attr : { 'href' : twitterUrl }"></a></span>
							<span class="button-checkbox">
								<button data-bind="attr: {class : btnInvitedClass}, click: check" type="button" class="btn btn-default" data-color="info">
									<i data-bind="attr : {class : faInviteClass}" class="fa fa-square-o"></i>&nbsp;<span data-bind="text: spanInvitedText"></span>
								</button>
								<input data-bind="checked: invite" type="checkbox" class="hidden">
							</span>
						</div>
					</td>			
				</tr>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="otherPlayersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div data-bind="with : selectedGameHistory" class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Other players</h4>
				</div>
				<div   class="modal-body">
					<table>
						<thead>
							<tr>
								<th>Name</th>
								<th>Score</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div>
										<span class="user-profile-img"><img data-bind="attr : {'src' : profileImageSrc}"></span>
										<span><a data-bind="text: username,attr : { 'href' : twitterUrl }"></a></span>
									</div>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

