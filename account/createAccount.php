<?php
	include('/include/include_all.php');

	echo"
		<html>
			<head>
				<title>Create an account</title>
				<link rel='stylesheet' href='/style/mainstyle.css'>
			</head>
			<body>
				<h1>Create a new account</h1>
				<div>";
	if(!IsLoggedIn()){
		CreateAccountForm();
		ShowLoginPage();

	}else{
		header("Location: /index.php");
	}
	echo"
				</div>
			</body>
		</html>
	";
Home();
