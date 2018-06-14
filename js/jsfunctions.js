//JS FUNCTIONS

function showLoginForm(){
	var form = document.getElementById('loginform');
	// console.log("showloginform");
	var hide = document.getElementById('intro');
	var hide2 = document.getElementById('createaccountform');
	// console.log(hide);
	$(hide).fadeOut();
	$(hide2).fadeOut();
	$(form).fadeIn();
}

function showCreateAccountForm(){
	var form = document.getElementById('createaccountform');
	// console.log("showloginform");
	var hide = document.getElementById('intro');
	var hide2 = document.getElementById('loginform');
	// console.log(hide);
	$(hide).fadeOut();
	$(hide2).fadeOut();
	$(form).fadeIn();
}
