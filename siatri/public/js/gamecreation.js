var _gamesHistory = [ {id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
{id: '1', hostName: "MihaiMarius", gameno : "50", score:"20 000", startDate : "12/12/2013"},
];

var otherPlayers = [
{username : 'MihaiMarius', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', score : '220'},
{username : 'MihaiMarius', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', score : '220'},
{username : 'MihaiMarius', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', score : '220'},
{username : 'MihaiMarius', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', score : '220'},
{username : 'MihaiMarius', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', score : '220'},
{username : 'MihaiMarius', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', score : '220'},
];

(function(){

//ko shortcuts
var obs = ko.observable;
var oAray = ko.observableArray;
var unwrap = ko.utils.unwrapObservable;

var vm = new GameCreationVM();

window.vm = vm;

GameCreationVM.prototype.load = function(){
	this.loadHost();
	this.loadGamesHistory();
	this.loadFriendList();
};


GameCreationVM.prototype.loadHost = function(){
	callAjax({
		url : '/getHostDetails',
		dataType: 'json',
	}).done(function (data){
		if( data && data.success)
		{
			var hostDetails = new PlayerVm(data.hostDetails);
			this.host(hostDetails);
		}else{
			bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
		}
	}.bind(this));
};

GameCreationVM.prototype.loadGamesHistory = function(){
	callAjax({
		url : '/getGameHistory',
		dataType: 'json',
	}).done(function (data){
		if( data && data.success)
		{
			var gamesHistory = [];
			for (var i = 0, length = _gamesHistory.length; i < length; i++) {
				gamesHistory.push(new GameHistoryVm(_gamesHistory[i]));
			};
			
			this.gameHistory(gamesHistory);

		}else{
			bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
		}
	}.bind(this));
}

GameHistoryVm.prototype.getOtherPlayers = function(){
	var gameId = unwrap(this.id);
	callAjax({
		url : '/getOtherPlayers',
		data : {
			gameId : gameId
		},
		dataType: 'json',
	}).done(function (data){
		if( data && data.success)
		{
			// var otherPlayers = [];
			// for (var i = 0, length = data.playersList.length; i < length; i++) {
			// 	otherPlayers.push(new PlayerVm(data.playersList[i]));
			// };
			this.players(otherPlayers);

		}else{
			bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
		}
	}.bind(this));
}

GameCreationVM.prototype.loadFriendList = function(){
	callAjax({
		url : '/getFriendsList',
		dataType: 'json',
	}).done(function (data){
		if( data && data.success)
		{
			var friends = [];
			for (var i = 0, length = data.friedsList.length; i < length; i++) {
				friends.push(new PlayerVm(data.friedsList[i]));
			};
			this.friendList(friends);
		}else{
			bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
		}
	}.bind(this));
}

$(function(){
	init();
});

return;

function GameCreationVM(){
	this.gameHistory  = oAray();
	this.friendList = oAray();
	this.host = obs();
	this.selectedGameHistory = obs();

	this.gameHistoryLoaded = obs(false);
	this.freindListLoaded = obs(false);

	this.searchedFriendName = obs();
	this.filteredFriedList = ko.computed({
		read : function (){
			var searchedFriendName = unwrap(this.searchedFriendName);
			searchedFriendName = searchedFriendName && searchedFriendName.toLowerCase();

			return result = ko.utils.arrayFilter(this.friendList(), function (friend) {
				return !searchedFriendName 
				|| friend.username().toLowerCase().indexOf(searchedFriendName) >= 0;
			}.bind(this));
		},
		owner: this,
	});

	this.selectedPlayers = function(){
		return ko.utils.arrayFilter(this.friendList(), function(friend){
			return unwrap(friend.invite);
		});
	};

	this.createGame = function(){
		var selectedUserIds = [];

		if (this.selectedPlayers().length < 1){

			bootstrapAlert("You must select at least one player to play a game.", Enum.alertType.error, true);
			return;
		}

		var selPlayers = this.selectedPlayers();
		for(var i in selPlayers)
		{
			selectedUserIds.push(unwrap(selPlayers[i].twitter_id));
		}

		callAjax({
			url : '/creategame',
			data:{
				selectedUserIds : selectedUserIds
			},
			type:'GET',
			dataType: 'json',
		}).done(function (data){
			if( data && data.success)
			{
				bootstrapAlert("Successfully sent invitations to selected players!", Enum.alertType.success, true);
			}else{
				bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
			}
		}.bind(this));

	};
}

function GameHistoryVm(data){
	this.id = obs(data && data.id);
	this.hostName = obs(data && data.hostName);
	this.gameno = obs(data && data.gameno);
	this.score = obs(data && data.score);
	this.startDate = obs(data && data.startDate);
	this.players = obs();

	this.viewOtherPlayers = function(){
		return true;	
	}
};

function PlayerVm(data){
	this.username = obs(data && data.username);
	this.twitter_id = obs(data && data.user_id);
	this.profileImageSrc = obs(data && data.profileImageSrc);
	this.twitterUrl = obs(data && data.twitterUrl);
	this.score = obs(data && data.score);

	this.invite = obs(false);

	this.spanInvitedText = ko.computed(function(){
		if(this.invite())
			return 'Invited';
		return 'Not invited';
	}, this);

	this.btnInvitedClass = ko.computed(function(){
		if(this.invite())
			return 'btn btn-success';
		return 'btn btn-default';
	}, this);

	this.faInviteClass = ko.computed(function(){
		if(this.invite())
			return 'fa fa-check-square-o';
		return 'fa fa-square-o';
	}, this);

	this.check = function(){
		this.invite(!this.invite());
	}
};


function init(){
	var element  = $('#')[0];

	ko.applyBindings(vm, element);

	vm.load();
}

})();



function postTweet(){
	callAjax({
		url : '/sendInvitation',
		data : {
			selectedUserIds : [2275883334]
		},
		dataType: 'json',
		type: 'POST', 
	}).done(function (data){
		if( data && data.success)
		{
			alert("Successfully sent game invitation");
		}else{
			alert("There was an error procesing your request");
		}
	});
}
