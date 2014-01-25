function callAjax(options){
	return $.ajax(options).fail(function(){
		if(options && $.isFunction(options.error)){
			options.error();
		}else
		{
			console.log("Http Ajax call  failed!");
		}
	});
}

var bootstrapAlertTimeout;

// bootstrap alert
function bootstrapAlert(message, type, autoFadeIn){
	clearTimeout(bootstrapAlertTimeout);

	if(type === undefined)
		type = Enum.alertType.success;

	if(autoFadeIn)
		bootstrapAlertTimeout = setTimeout(function(){
			hideBoostrapAlert();
		}, 5000);
	
	$('div.divAlert > div.alert').addClass(type);
	$('div.alert > div.message').text(message);
	$('div.divAlert').show();
}

function hideBoostrapAlert(){
	$('div.divAlert').hide();
	$('div.divAlert > div.alert').removeClass(Enum.alertType.success)
								.removeClass(Enum.alertType.info)
								.removeClass(Enum.alertType.warning)
								.removeClass(Enum.alertType.error);

}