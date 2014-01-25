var dummyPlayers = [
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	},
{ username : 'MariusMihai', twitterUrl:'http://twitter.com/mariusmihai', profileImageSrc : '/img/user.png', points : '500', games : '50'	}
];

(function (){

	var viewModel = new TopVM();

	TopVM.prototype.load = function (){
		//TODO: add ajax call to get players
		var players = [];
		for (var i = 0, length = dummyPlayers.length; i < length; i++) {
			players.push(new PlayerVM(dummyPlayers[i], this));
		};

		this.players(players);
	};	

	$(function(){
		init();
	});

	return ;

	function TopVM(){
		this.players = ko.observableArray([]);

	};

	function PlayerVM (data){
		this.username = ko.observable(data && data.username);
		this.twitterUrl = ko.observable(data && data.twitterUrl);
		this.profileImageSrc = ko.observable(data && data.profileImageSrc);
		this.points = ko.observable(data && data.points);
		this.games = ko.observable(data && data.games);
	}

	function init(){
		var element = $('#koWrapper')[0];

		ko.applyBindings(viewModel, element);
		viewModel.load();
	}
})();