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