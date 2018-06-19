<?php
	include('/include/include_all.php');
	// var_dump($_SESSION);

	if(isset($_REQUEST['logout'])){
		logout();
		// var_dump($_SESSION);
	}
	$errors = array();
	if(isset($_REQUEST['loginsub'])){		//VALIDATE LOGIN
		// var_dump($_REQUEST);
		$errors+=validateTextField('username');
		$errors+=validatePasswordField('password');
		if(isset($_REQUEST['username'])){
			$errors+=validateUserExists($_REQUEST['username']);
			if(isset($_REQUEST['password'])){
				$errors+=validateCorrectPassword($_REQUEST['password'], $_REQUEST['username']);
			}
		}
		// var_dump($errors);
		// die();
		if(sizeof($errors) == 0){
			login();
		}else{
			displayErrors($errors);
		}
	}

	if(isset($_REQUEST['createsub'])){		//VALIDATE CREATE ACCOUNT
		$errors+=validateTextField('fname');
		$errors+=validateTextField('lname');
		$errors+=validateTextField('username');
		$errors+=validatePasswordField('password');
		$errors+=validatePasswordField('confirm');
		if(isset($_REQUEST['username'])){
			$errors+=validateUserTaken($_REQUEST['username']);
		}
		if((isset($_REQUEST['password']))&&(isset($_REQUEST['confirm']))){
			$errors+=validateConfirmPassword($_REQUEST['password'], $_REQUEST['confirm']);
		}
		if(sizeof($errors) == 0){
			createUser($_REQUEST['fname'], $_REQUEST['lname'], $_REQUEST['username'], $_REQUEST['password']);
		}else{
			displayErrors($errors);
		}
	}


	head('Yolo Jar');
	echo"
		<div id='intro'>
			<p>inspired by Tim Bono's<br><div class='booktitle'>When Likes Aren't Enough</div></p>
	";
	// var_dump(isLoggedIn());
	if(isLoggedIn()){
		// var_dump(getCurrentUsername());
		echo"
			<div class='banner'>
				Welcome, <a href='/account/user_settings.php?userid=".$_SESSION['userid']."'>".getCurrentFname()."</a>
			</div>

		";
		userTimelineLink();
		logoutButton();
	}else{
		loginButton();
		echo"<br><br>or<br><br>";
		createAccountButton();
		echo"</div>
			<div id='loginform'>
				<form method='post'>";
					formTextField('username', 'Username');
					formPasswordField('password', 'Password');
		echo"
					<input type='submit' name='loginsub' value='login'>
				</form>";
		createAccountButton();
		echo"
			</div>
			<div id='createaccountform'>
				<form method='post'>";
					formTextField('fname', 'First Name');
					formTextField('lname', 'Last Name');
					formTextField('username', 'Username');
					formPasswordField('password', 'Password');
					formPasswordField('confirm', 'Confirm Password');
		echo"
					<input type='submit' name='createsub' value='create account'>
				</form>";
		loginButton();
		echo"
			</div>
		";
	}
	echo"
		<button class='jarButton' onclick='toggleYoloDescription()'>What is a Yolo Jar?</button>
		<div class='yoloDescription'>
			DESCRIPTION
		</div>
	";

	foot();
