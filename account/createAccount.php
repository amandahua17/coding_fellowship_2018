<?php
	include('/include/include_all.php');
	if(IsLoggedIn()){
		header("Location: /index.php");
	}
	Heading("Create Account", "Create An Account");
	CreateAccountForm();
	Footer();
