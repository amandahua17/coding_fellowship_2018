<?php
	//CSS FUNCTIONS

	//DATABASE FUNCTIONS
	function GetTheme($userID){
		$result = dbQuery("
			SELECT *
			INNER JOIN themes
			ON users AS themes.themeID = users.themeID
			WHERE userID = :userID
		", array('userID'=>$userID))->fetch();
		return $result;
	}

	function GetBlogColor($userID){

	}

	function GetPicColor($userID){

	}

	function GetUserColor($userID){
		
	}

	function ChangeTheme($new){
		$result = dbQuery("
			UPDATE users
			SET themeID = :new
			WHERE userID = :userID
		", array('new'=>$new, 'userID'=>$_SESSION['userID']))->fetch();
		return $result;
	}

	function GetDefaultTheme(){
		$result = dbQuery("
			SELECT *
			FROM themes
			WHERE themeID = 1
		")->fetch();
		return $result;
	}

	//OTHER FUNCTIONS
	function GetCurrentTheme(){
		return $_SESSION['themeID'];
	}
