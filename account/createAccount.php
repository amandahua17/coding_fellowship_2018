<?php
	include('/include/include_all.php');
	if(IsLoggedIn()){
		header("Location: /index.php");
	}
	Heading("Create Account", "Create An Account");

	$errors = array();
	if(isset($_REQUEST['create'])){
		$errors+=ValidateTextField('username', $errors);
		$errors+=ValidateTextField('password', $errors);
		$errors+=ValidateTextField('confirm', $errors);
		$errors+=ValidateTextField('email', $errors);
		$errors+=ValidatePasswordConfirmation('password', 'confirm', $errors);
		$errors+=ValidateUserTaken($_REQUEST['username'], $_REQUEST['email']);

		if(sizeof($errors) == 0){
			AddNewUser($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email']);
			header("Location: /account/login.php");
			exit();
		}else{
			foreach($errors as $name=>$error){
				DisplayError($name, $error);
			}
		}
	}

	echo"
	<div class='usercontainer'>
		<form method='post'>
	";
	ShowTextField(true, 'username');
	ShowPasswordField('password', 'password');
	ShowPasswordField('confirm', 'confirm password');
	ShowTextField(true, 'email');
	echo"<input type='submit' name = 'create' value='Create Account'>
		</form>
	</div>";

	Footer();
