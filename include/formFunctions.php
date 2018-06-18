<?php
	//FORM FUNCTIONS

	function formTextField($name, $label){
		echo"
			$label: <input type='text' name=$name
			";
		if(isset($_REQUEST[$name])){
			echo"value = $_REQUEST[$name]";
		}
		echo"><br><br>
		";
	}

	function formPasswordField($name, $label){
		echo"
			$label: <input type='password' name=$name
			";
		if(isset($_REQUEST[$name])){
			echo"value = $_REQUEST[$name]";
		}
		echo"><br><br>
		";
	}

	function validateTextField($name){
		$errors = array();
		if(!isset($_REQUEST[$name])){
			$errors[$name] = 'required!';
		}else if(($_REQUEST[$name] == NULL)||($_REQUEST[$name] == '')){
			$errors[$name] = 'required!';
		}
		return $errors;
	}

	//VALidATE FUNCTIONS
	function validatePasswordField($name){
		$errors = array();
		if(!isset($_REQUEST[$name])){
			$errors[$name] = 'required!';
		}else if(($_REQUEST[$name] == NULL)||($_REQUEST[$name] == '')){
			$errors[$name] = 'required!';
		}
		return $errors;
	}

	function validateConfirmPassword($password, $confirm){
		$errors = array();
		if($password != $confirm){
			$errors['match'] = 'Passwords do not match!';
		}
		return $errors;
	}

	function displayErrors($errors){
		foreach($errors as $key=>$error){
			if($key == 'match'){
				echo "<div class='error'>$error</div>";
			}else{
				echo"<div class='error'>$key $error</div>";
			}
		}
	}
	//DATABASE FUNCTIONS
	function validateCorrectPassword($password, $username){
		$errors = array();
		$result = dbQuery("
			SELECT password
			FROM users
			WHERE username = :username
		", array('username' => $username))->fetch();
		if($result['password'] != $password){
			$errors['match'] = 'Incorrect password!';
		}
		return $errors;
	}

	function validateUserTaken($username){
		$errors = array();
		$result = dbQuery("
			SELECT *
			FROM users
			WHERE UPPER(username) = UPPER(:username)
		", array('username' => $username))->fetch();
		if($result){
			$errors['match'] = 'Username taken!';
		}
		return $errors;
	}

	function validateUserExists($username){
		$errors = array();
		$result = dbQuery("
			SELECT *
			FROM users
			WHERE username = :username
		", array('username' => $username))->fetch();
		if(!$result){
			$errors['match'] = 'User Does Not Exist!';
		}
		return $errors;
	}

	//USER SETTINGS FORMS
	function changeUsernameForm(){
		$errors = array();
		if(isset($_REQUEST['change'])){
			$errors += validateTextField('newUsername');
			$errors += validateTextField('password');
			if(!isset($errors['newUsername'])){
				$errors += validateUserTaken($_REQUEST['newUsername'], '');
			}
			if($_REQUEST['password']!=getUser($_SESSION['username'])['password']){
				$errors['match']='Incorrect Password!';
			}
			if(sizeof($errors) == 0){
				ChangeUsername($_SESSION['userid'], $_REQUEST['newUsername']);
				header("Location: /account/user_settings.php?option=6");
				exit();
			}else{
				displayErrors($errors);
			}
		}
		echo"
		<div class='usercontainer'>
			<form method='post'>
				";
				formTextField('newUsername', 'New Username');
				formPasswordField('password', 'Password');
		echo"
				<input type='submit' name='change'>
			</form>
		</div>
		";
	}

	function changePasswordForm(){
		$errors = array();
		if(isset($_REQUEST['change'])){
			$errors += validateTextField('newpswd');
			$errors += validateTextField('confirm');
			$errors += validateTextField('oldpswd');
			$errors += validateConfirmPassword('newpswd', 'confirm');
			if($_REQUEST['oldpswd']!=GetUser($_SESSION['username'])['password']){
				$errors['old']='Incorrect Password!';
			}
			if(sizeof($errors) == 0){
				changePassword($_SESSION['userid'], $_REQUEST['newpswd']);
				header("Location: /account/user_settings.php?option=6");
				exit();
			}else{
				DisplayErrors($errors);
			}
		}
		echo"
		<div class='usercontainer'>
			<form method='post'>
				";
				formPasswordField('newpswd', 'New Password');
				formPasswordField('confirm', 'Confirm New Password');
				formPasswordField('oldpswd', 'Old Password');
		echo"
				<input type='submit' name='change'>
			</form>
		</div>
		";
	}

	function changeThemeForm(){
		if(isset($_REQUEST['change'])){
			changeTheme($_REQUEST['theme']);
			header("Location: /account/user_settings.php?option=3");
		}
		$val = 1;
		if(isset($_SESSION['theme'])){
			$val = $_SESSION['theme'];
		}
		echo"
			<form method='post'>
				<select name='theme'>";
		echo"<option value='1'";
		if($val == 1){
			echo" selected";
		}
		echo">default (yellow)</option>
					<option value='2'";
		if($val == 2){
			echo" selected";
		}
		echo">red</option>
					<option value='3'";
		if($val == 3){
		echo" selected";
		}
		echo">green</option>
					<option value='4'";
		if($val == 4){
		echo" selected";
		}
		echo">blue</option>
					<option value='5'";
		if($val == 5){
		echo" selected";
		}
		echo">purple</option>
					<option value='6'";
		if($val == 6){
		echo" selected";
		}
		echo">orange</option>
					<option value='7'";
		if($val == 7){
		echo" selected";
		}
		echo">pink</option>
					<option value='8'";
		if($val == 8){
		echo" selected";
		}
		echo">dark</option>
			</select><br><br>
				<input type='submit' value='Change Theme' name='change'>
			</form>
		";
	}
