<?php

	//NOTES:
		//"Show" shows a field, button, or link (home, form, etc.)
		//"Display" shows an element (tag, comment, etc.)

	//Contains HTML and form functions

	//RANDOM FUNCTIONS
	function Heading($title, $h1){
		echo"
			<html>
				<header>
					<title>$title</title>
					<link rel='stylesheet' href='/style/mainstyle.php'>
					<script src='/js/jquery.js'></script>
				</header>
				<body>";
		if(IsLoggedIn()){
			PersonalHeading();
		}
		if(!IsLoggedIn()){
			ShowLoginPageLink();
			ShowCreateAccountPage();
			if($title == 'Create Post'){
				echo"note: if you are not logged in, only an admin can edit or delete your post. To make it so that you can edit or delete your post, log in or create an account.<br>";
			}
		}
		if($h1 != ""){
			echo"
						<h1>".$h1."</h1>";
		}

	}

	function Footer($val=''){
		ShowJS();
		echo"
			</body>
		</html>
		";
		if($val==''){
			ShowHomeLink();
		}
	}

	function TypeBasedEcho($type, $stringarray){
		foreach($stringarray as $key=>$string){
			if($type == $key){
				echo $string;
				return;
			}
		}
	}

	//SHOW FUNCTIONS
	function ShowHomeLink(){
		echo"
			<a class='home' href='/index.php'>back to home</a>
		</html>";
	}

	function ShowDeleteButton($postID){
		if(isset($_REQUEST['delete'])){
			if(HasDeletePermission($postID)){
				DeletePost($postID);
				header("Location: /index.php");
				exit();
			}else{
				echo"You do not have permission to delete this post.";
			}
		}
		echo"
			<form method='post'>
				<input type='submit' name='delete' value='Delete Post'><br><br>
			</form>
		";

	}

	function ShowLoginPageLink(){
		echo"
			<a href='/account/login.php'>Log In</a><br>
		";
	}

	function ShowCreateAccountPage(){
		echo"
			<a href='/account/createAccount.php'>Create an account</a><br>
		";
	}

	function ShowEditButton($postID){
		// echo"ShowEditButton called";
		// var_dump($postID);
		if(isset($_REQUEST['edit'.$postID])){
			// echo"edit button pushed";
			// die();
			if(HasEditPermission($postID)){
				// echo"Go to Edit!";
				// die();
				header("Location: /edit_post.php?postID=".$postID);
			}else{
				echo"You do not have permission to edit this post!";
			}
		}
		echo"
			<form method='post'>
				<input type='submit' name='edit".$postID."' value='Edit Post'><br><br>
			</form>
		";
	}

	function ShowSettings(){
		echo"<a href='/account/user_settings.php'>User Settings</a><br>";
	}

	function ShowFlavorInfo(){
		echo"
			<div class='flavorInfo' id='flavorInfo'>
				<p>In a game, sometimes items, actions, or mechanics etc. will have flavor text, which are just extra snippets of text that
				<br>aren't related to actual gameplay rules or affect anything-- they're just there for effect. It's pretty much just fluff,
				<br>but it can add realism, enhance the tone, include extra background information or narrative, or be funny. (Urban Dictionary)
				<br>In the context of this site, flavor text is essentially the same as as in a game, it's a small snippet that will pop up if
				<br>the picture doesn't load.</p>
			</div>
		";
	}

	function ShowJS(){				//function credits to RobertPitt on stackoverflow
		echo("<script type=\"text/javascript\" src=\"/js/jquery.js\"></script>");
		echo("<script type=\"text/javascript\" src=\"/js/jsFunctions.js\"></script>");
	}

	//FORM FUNCTIONS
	function ValidateTextField($key, $errors){
		// var_dump($_REQUEST);
		if(!isset($_REQUEST[$key])||($_REQUEST[$key]) == ''){
			$errors[$key] = "required";
		}
		return $errors;
	}

	function ValidatePasswordConfirmation($pswdname, $confirmname, $errors){
		if((isset($errors['$pswdname']))&&(isset($errors['$confirmname']))){
			if($_REQUEST['$pswdname'] != $_REQUEST['$confirmname']){
				$errors['match'] = 'error';
			}
		}
		return $errors;
	}

	function ShowTextField($isreq, $name, $value=''){
		echo"
			<p";
		if($isreq){
			echo" class='required'";
		}
		echo">$name";
		if($isreq){
			echo"*";
		}

		echo":</p><input type='text' name='$name'";
		if($value == ''||$value == NULL){
			if(isset($_REQUEST[$name])){
				echo"value='".addslashes($_REQUEST[$name])."'";
			}
		}else{
			echo"value='".addslashes($value)."'";
		}
		echo"><br><br>
		";
	}

	function ShowPasswordField($name, $text){
		echo"
			<p class='required'>$text*:</p><input type='password' name='$name'";
		if(isset($_REQUEST[$name])){
			echo"value='".addslashes($_REQUEST[$name])."'";
		}
		echo"><br><br>
		";
	}

	function DisplayError($errorname, $error){
		// var_dump($errorname, $error);
		if(!$error){
			return;
		}
		if($error == 'required'){
			echo"<div class='required'>Please enter $errorname.</div>";
		}else if($errorname == 'match'){
			echo"<div class='required'>Does not match.</div>";
		}else if($errorname == 'DNE'){
			echo"<div class='required'>There is no account associated with that username.</div>";
		}else{ //if($errorname == 'taken'){
			echo"<div class='required'>$error</div>";
		}
		// }else if($errorname == 'old'){
		// 	echo"<div class='required'>$error</div>";
		// }else{
		// 	echo"<div class='required'>undefined error</div>";
		// }
	}

	function ValidateUserTaken($username, $email){
		$errors = array();
		if(UserExists($username)){
			$errors['taken'] = 'Username taken!';
		}
		if(UserEmailExists($email)){
			$errors['taken'] = 'Email taken!';
		}
		return $errors;
	}

	function ShowTagField(){
		echo"
			<p >tags:</p><input type='text' name='tags'>
			<input type='submit' name='tagsub' value='add tag'>
			<br><br>
		";
	}

	function ShowHiddenField($name, $value){
		echo"
		<input type='hidden' name='$name' value='".addslashes($value)."'><br>
		";
	}

	function ValidateActive($username, $errors){
		if(!GetUser($username)['active']){
			$errors['active'] = 'Account Not Active!';
		}
		return $errors;
	}

	//ACTUAL FORMS
	function ShowAddCommentForm($postID){
		$errors = array();

		if(isset($_REQUEST['commentsub'.$postID])){
			$errors+=ValidateTextField('Comment', $errors);
			if(sizeof($errors)==0){
				AddNewComment($_REQUEST['Comment'], $postID);
			}else{
				DisplayError('Comment', $errors['Comment']);
			}
		}

		echo"
			<form method='post'>";
			ShowTextField(false,'Comment','');
		echo"
				<input type='submit' name='commentsub".$postID."' value='comment'>
			</form>
		";
	}

	function ChangeUsernameForm(){
		$errors = array();

		if(isset($_REQUEST['change'])){
			$errors += ValidateTextField('NewUsername', $errors);
			$errors += ValidateTextField('password', $errors);
			if(!isset($errors['NewUsername'])){
				$errors += ValidateUserTaken($_REQUEST['NewUsername'], '');
			}
			if($_REQUEST['password']!=GetUser($_SESSION['username'])['password']){
				$errors['match']='Incorrect Password!';
			}
			if(sizeof($errors) == 0){
				ChangeUsername($_SESSION['userID'], $_REQUEST['NewUsername']);
				header("Location: /account/user_settings.php?option=6");
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
				ShowTextField(true, 'NewUsername', '');
				ShowPasswordField('password', 'Password');
		echo"
				<input type='submit' name='change'>
			</form>
		</div>
		";
	}

	function ChangePasswordForm(){
		$errors = array();

		if(isset($_REQUEST['change'])){
			$errors += ValidateTextField('newpswd', $errors);
			$errors += ValidateTextField('confirm', $errors);
			$errors += ValidateTextField('oldpswd', $errors);
			$errors += ValidatePasswordConfirmation('newpswd', 'confirm', $errors);
			if($_REQUEST['oldpswd']!=GetUser($_SESSION['username'])['password']){
				$errors['old']='Incorrect Password!';
			}
			if(sizeof($errors) == 0){
				ChangePassword($_SESSION['userID'], $_REQUEST['newpswd']);
				header("Location: /account/user_settings.php?option=6");
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
				ShowPasswordField('newpswd', 'New Password');
				ShowPasswordField('confirm', 'Confirm New Password');
				ShowPasswordField('oldpswd', 'Old Password');
		echo"
				<input type='submit' name='change'>
			</form>
		</div>
		";
	}

	function NicknameForm(){
		$errors = array();

		if(isset($_REQUEST['change'])){
			$errors += ValidateTextField('Nickname', $errors);
			$errors += ValidateTextField('password', $errors);
			if($_REQUEST['password']!=GetUser($_SESSION['username'])['password']){
				$errors['match']='Incorrect Password!';
			}
			if(sizeof($errors) == 0){
				SetNickname($_SESSION['userID'], $_REQUEST['Nickname']);
				$_SESSION['nickname'] = $_REQUEST['Nickname'];
				header("Location: /account/user_settings.php?option=6");
				exit();
			}else{
				foreach($errors as $name=>$error){
					DisplayError($name, $error);
				}
			}
		}else{

		}

		echo"
		<div class='usercontainer'>
			<form method='post'>
				";
				ShowTextField(true, 'Nickname', '');
				ShowPasswordField('password', 'Password');
		echo"
				<input type='submit' name='change'>
			</form>
		</div>
		";
	}

	function DeactivateAccountForm(){
		$errors = array();

		if(isset($_REQUEST['delete'])){
			$errors += ValidateTextField('password', $errors);
			if($_REQUEST['password']!=GetUser($_SESSION['username'])['password']){
				$errors['match']='Incorrect Password!';
			}
			if(sizeof($errors) == 0){
				DeactivateUser($_SESSION['userID']);
				header("Location: /account/user_settings.php?option=5");
				exit();
			}else{
				foreach($errors as $name=>$error){
					DisplayError($name, $error);
				}
			}
		}

		echo"
		<div class='usercontainer'>
			<form method='post'>";
				ShowPasswordField('password', 'Password');
		echo"
				<input type='submit' name='delete' value='Deactivate Account'>
			</form>
		</div>
		";
	}
