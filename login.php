<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	include('include/include_all.php');

	echo"
		<html>
			<head>
				<title>Login</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>Log In</h1>
				<div>";
	if(!IsLoggedIn()){
		Login();
		CreateAccountPage();
	}else{
		echo"You are already logged in!";
	}
	echo"
				</div>
			</body>
		</html>
	";
Home();
