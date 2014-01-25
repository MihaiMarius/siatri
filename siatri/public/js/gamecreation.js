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
