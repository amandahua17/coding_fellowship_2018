<?php
	include('/include/include_all.php');
	if(IsLoggedIn()){
		header("Location: /index.php");
	}
	Heading("Login", "Login");

	$errors = array();
	// var_dump($_REQUEST);
	if(isset($_REQUEST['login'])){
		// var_dump($_REQUEST);
		$errors+=ValidateTextField('password', $errors);
		$errors+=ValidateTextField('username', $errors);
		if(!isset($errors['username'])&&UserExists($_REQUEST['username'])){
			if(GetUser($_REQUEST['username'])['password'] != $_REQUEST['password']){
				$errors['match'] = 'incorrect password!';
			}
			$errors+=ValidateActive($_REQUEST['username'], $errors);
		}else{
			$errors['DNE'] = 'user does not exist!';
		}

		if(sizeof($errors) == 0){
			// var_dump($_REQUEST, GetUser($_REQUEST['username'])['userID']);
			// die();
			$_SESSION['username'] = $_REQUEST['username'];
			$_SESSION['userID'] = GetUser($_REQUEST['username'])['userID'];
			if(HasNickname($_SESSION['userID'])){
				$_SESSION['nickname'] = GetUser($_REQUEST['username'])['nickname'];
			}
			header("Location: /index.php");
			exit();
		}else{
			// var_dump($errors);
			foreach($errors as $key=>$error){
				DisplayError($key, $error);
			}
			// if(isset($errors)){
			// 	echo"<div class='required'>Please enter your username.</div>";
			// }
			// if(isset($errors['password'])){
			// 	echo"<div class='required'>Please enter your password.</div>";
			// }
			// if(isset($errors['match'])){
			// 	echo"<div class='required'>Your username and password do not match.</div>";
			// }
			// if(isset($errors['DNE'])){
			// 	echo"<div class='required'>There is no account associated with that username.</div>";
			// }
		}
	}
	echo"<form method='post'>";
	ShowTextField(true, 'username');
	ShowPasswordField('password', 'password');
	echo"<input type='submit' name = 'login' value='Login'>
		</form>";

	Footer();
