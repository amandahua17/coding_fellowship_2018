<?php
	//USER FUNCTIONS
	function isLoggedIn(){
		if(isset($_SESSION['userid'])){
			return true;
		}
		return false;
	}

	function getCurrentUsername(){
		if(isLoggedIn()){
			// var_dump(getUser($_SESSION['userid']));
			return getUser($_SESSION['userid'])['username'];
		}
		return false;
	}

	function getCurrentFname(){
		if(isLoggedIn()){
			// var_dump(getUser($_SESSION['userid']));
			return getUser($_SESSION['userid'])['firstname'];
		}
		return false;
	}

	function login(){
		if(isset($_REQUEST['username'])){
			$_SESSION['userid'] = getUserid($_REQUEST['username']);
			// var_dump($_SESSION);
			// die();
			header("Location: /index.php");
		}else{
			echo "ERROR: no username!<br>";
			return false;
		}
	}

	function logout(){
		session_destroy();
		header("Location: /index.php");
	}

	function getTheme(){
		if(!isset($_SESSION['userid'])){
			return 1;
		}
		$result = dbQuery("
			SELECT theme
			AS theme
			FROM users
			WHERE userid = :userid
		", array('userid'=>$_SESSION['userid']))->fetch();
		return $result['theme'];
	}

	//DATABASE FUNCTIONS
	function getUser($userid){
		$result = dbQuery("
			SELECT *
			FROM users
			WHERE userid = :userid
		", array('userid'=>$userid))->fetch();
		return $result;
	}

	function getUserid($username){
		$result = dbQuery("
			SELECT userid
			AS id
			FROM users
			WHERE username = :username
		", array('username'=>$username))->fetch();
		return $result['id'];
	}

	function createUser($fname, $lname, $username, $password){
		$result = dbQuery("
			INSERT INTO users
			(firstname, lastname, username, password)
			VALUES (:fname, :lname, :username, :password)
		", array('fname'=>$fname, 'lname'=>$lname, 'username'=>$username, 'password'=>$password))->fetchAll();
		$_SESSION['userid'] = getUserid($username);
	}

	function getBeginningDate(){
		$result = dbQuery("
			SELECT DATE_FORMAT(beginning, '%m-%d-%Y')
			AS date
			from users
			WHERE userid = :userid
		", array('userid'=>$_SESSION['userid']))->fetch();
		return $result['date'];
	}
	//USER SETTINGS FUNCTIONS
	function changeUsername($userid, $newname){
		// var_dump($userid, $newname);
		$result=dbQuery("
			UPDATE users
			SET username = :newname
			WHERE userid = :userid
		", array('userid'=>$userid, 'newname'=>$newname))->fetch();
		$_SESSION['username'] = $newname;
	}

	function changePassword($userid, $newpswd){
		$result=dbQuery("
			UPDATE users
			SET password = :newpswd
			WHERE userid = :userid
		", array('userid'=>$userid, 'newpswd'=>$newpswd))->fetch();
	}

	function changeTheme($theme){
		$result=dbQuery("
			UPDATE users
			SET theme = :theme
			WHERE userid = :userid
		", array('theme'=>$theme, 'userid'=>$_SESSION['userid']))->fetch();
		$_SESSION['theme'] = $theme;
	}
