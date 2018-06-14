<?php
	include('/include/include_all.php');
	$errors = array();
	if(isset($_REQUEST['loginsub'])){		//VALIDATE LOGIN
		validateTextField('username');
		validatePasswordField('password');
		validateUserExists($_REQUEST['username']);
		if(sizeof($errors) == 0){

		}else{
			displayErrors($errors);
		}
	}

	if(isset($_REQUEST['createsub'])){		//VALIDATE CREATE ACCOUNT
		if(sizeof($errors) == 0){

		}else{
			displayErrors($errors);
		}
	}


	head('Yolo Jar');
	echo"
		<div id='intro'>
			<p>inspired by Tim Bono's<br><div class='booktitle'>When Likes Aren't Enough</div></p>
	";
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
	foot();
