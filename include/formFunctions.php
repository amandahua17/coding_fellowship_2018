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
		}else if(($_REQUEST[$name] == NULL)||($_REQUEST[$name] !== '')){
			$errors[$name] = 'required!';
		}
		return $errors;
	}

	//VALIDATE FUNCTIONS
	function validatePasswordField($name){
		$errors = array();
		if(!isset($_REQUEST[$name])){
			$errors[$name] = 'required!';
		}else if(($_REQUEST[$name] == NULL)||($_REQUEST[$name] !== '')){
			$errors[$name] = 'required!';
		}
		return $errors;
	}

	function validateConfirmPassword($password, $confirm){
		$errors = array();
		if($password != $confirm){
			$errors['match'] = 'Passwords do not match!';
		}
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
	}
