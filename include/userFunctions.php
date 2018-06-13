<?php
//USER FUNCTIONS

//USER FUNCTIONS
function IsLoggedIn(){
	echo"";
	if(isset($_SESSION['userID'])){
		return true;
	}
	return false;
}

function PersonalHeading(){
	if(isset($_SESSION['nickname'])){
		echo"
			<p class='personal'>hi <a href='/view_user?userID=".$_SESSION['userID']."'>".($_SESSION['nickname'])."</a></p>
		";
	}else{
		echo"
			<p class='personal'>hi <a href='/view_user?userID=".$_SESSION['userID']."'>".$_SESSION['username']."</a></p>
		";
	}
	ShowSettings();
	echo"<br>";
	Logout();
}

function Logout(){
	if(isset($_REQUEST['logout'])){
		// echo"<script>
		// 		alert('Are you sure you want to log out?')
		// 	</script>
		// ";
		session_destroy();
		header("Location: /index.php");
		exit();
	}
	echo"
		<form>
			<input class='personal' type='submit' name='logout' value='Log Out'>
		</form>
	";
}

function HasDeletePermission($postID){
	// echo"HasDeletePermission called";
	// var_dump($_SESSION);
	if(isset($_SESSION['userID'])){
		if($_SESSION['userID'] == GetPostCreator($postID)){
			return true;
		}
		if(GetUser($_SESSION['username'])['userType'] == 'admin'){
			return true;
		}
		if(GetPostCreator == 0){
			return true;
		}
	}
	// if(GetPostCreator($postID) == NULL){
	// 	return true;
	// }
	return false;
}

function HasEditPermission($postID){
	if(isset($_SESSION['userID'])){
		if($_SESSION['userID'] == GetPostCreator($postID)){
			return true;
		}
		if(GetPostCreator == 0){
			return true;
		}
	}
	// if(GetPostCreator($postID) == NULL){
	// 	return true;
	// }
	return false;
}

function ValidComment(){
	if(isset($_SESSION['userID'])){
		return true;
	}
	return false;
}

function ValidEditComment($commentID){
	if(isset($_SESSION['userID'])){
		if($_SESSION['userID']==GetComment($commentID)['userID']){
			return true;
		}
	}
	return false;
}

function GetPostCreator($postID){
	return GetPost($postID)['userID'];
}

//USER SETTINGS FUNCTIONS
function ChangeUsername($userID, $newname){
	// var_dump($userID, $newname);
	$result=dbQuery("
		UPDATE users
		SET username = :newname
		WHERE userID = :userID
	", array('userID'=>$userID, 'newname'=>$newname))->fetch();
	$_SESSION['username'] = $newname;
}

function ChangePassword($userID, $newpswd){
	$result=dbQuery("
		UPDATE users
		SET password = :newpswd
		WHERE userID = :userID
	", array('userID'=>$userID, 'newpswd'=>$newpswd))->fetch();
}

function SetNickname($userID, $name){
	$result=dbQuery("
		UPDATE users
		SET nickname = :name
		WHERE userID = :userID
	", array('userID'=>$userID, 'name'=>$name))->fetch();
}

function HasNickname($userID){
	$result=dbQuery("
		SELECT nickname
		FROM users
		WHERE userID = :userID
	", array('userID'=>$userID))->fetch();
	// var_dump($result, $userID);
	if((!$result)||($result['nickname'] == null)){
		return false;
	}
	return true;
}

function DeactivateUser($userID){
	session_destroy();
	$result=dbQuery("
		UPDATE users
		SET active = 0
		WHERE userID = :userID
	", array('userID'=>$userID))->fetch();
}

function ReactivateUser($userID){
	$result=dbQuery("
		UPDATE users
		SET active = 1
		WHERE userID = :userID
	", array('userID'=>$userID))->fetch();
}

function ChangeTheme($themeID){
	$result=dbQuery("
		UPDATE users
		SET themeID = :themeID
		WHERE userID = :userID
	", array('themeID'=>$themeID, 'userID'=>$_SESSION['userID']))->fetch();
	$_SESSION['themeID'] = $themeID;
}

//USER DATABASE FUNCTIONS
function AddNewUser($username, $password, $email){
	$result = dbQuery("
		INSERT INTO users (username, password, userType, email, active)
		VALUES(:username, :password, 'regUser', :email, 1)
	", array('username'=>$username, 'password'=>$password, 'email'=>$email))->fetch();
}

function UserExists($username){
	$result = dbQuery("
		SELECT *
		FROM users
		WHERE LOWER(username) = LOWER(:username)
	", array('username'=>$username))->fetch();
	if(!$result){
		return false;
	}
	return true;
}

function UserEmailExists($email){
	$result = dbQuery("
		SELECT *
		FROM users
		WHERE LOWER(email) = LOWER(:email)
	", array('email'=>$email))->fetch();
	if(!$result){
		return false;
	}
	return true;
}

function GetUser($username){
	$result = dbQuery("
		SELECT *
		FROM users
		WHERE username = :username
	", array('username'=>$username))->fetch();
	return $result;
}

function GetUserWithID($userID){
	$result = dbQuery("
		SELECT *
		FROM users
		WHERE userID = :userID
	", array('userID'=>$userID))->fetch();
	return $result;
}


function GetPostsWithUser($userID){
	$result = dbQuery("
		SELECT *
		FROM posts
		WHERE userID = :userID
	", array('userID'=>$userID))->fetchAll();
	return $result;
}
