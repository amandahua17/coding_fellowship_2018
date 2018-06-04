
<?php

	//RANDOM FUNCTIONS
	function Home(){
		echo"
			<a class='home' href='index.php'>back to home</a>
			";
	}

	function ShowDelete($postID){
		if(isset($_REQUEST['delete'])){
			if(ValidDelete($postID)){
				DeletePost($postID);
				header("Location: index.php");
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

	function ShowLoginPage(){
		echo"
			<a href='login.php'>Log In</a><br>
		";
	}

	function ShowCreateAccountPage(){
		echo"
			<a href='createAccount.php'>Create an account</a><br>
		";
	}

	function GetTypeInfo($type){

	}

	//FORM FUNCTIONS
	function ValidateTextField($key, $errors){
		if(!$_REQUEST[$key]){
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

	function ShowTextField($isreq, $name){
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
		if(isset($_REQUEST[$name])){
			echo"value='$_REQUEST[$name]'";
		}
		echo"><br><br>
		";
	}

	function ShowPasswordField($name, $text){
		echo"
			<p class='required'>$text*:</p><input type='password' name='$name'";
		if(isset($_REQUEST[$name])){
			echo"value='$_REQUEST[$name]'";
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
		}else if($errorname == 'taken'){
			echo"<div class='required'>$error</div>";
		}else{
			echo"undefined error";
		}
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

	//USER FUNCTIONS
	function CreateAccountForm(){
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
				header("Location: login.php");
				exit();
			}else{
				foreach($errors as $name=>$error){
					DisplayError($name, $error);
				}
				// if(isset($errors['username'])){
				// 	echo"<div class='required'>Please enter your username.</div>";
				// }
				// if(isset($errors['password'])){
				// 	echo"<div class='required'>Please enter your password.</div>";
				// }
				// if(isset($errors['confirm'])){
				// 	echo"<div class='required'>Please confirm your password.</div>";
				// }
				// if(isset($errors['password'])){
				// 	echo"<div class='required'>Please enter your email.</div>";
				// }
				// if(isset($errors['match'])){
				// 	echo"<div class='required'>Your passwords do not match.</div>";
				// }
			}
		}

		echo"
			<form method='post'>
		";
		ShowTextField(true, 'username');
		ShowPasswordField('password', 'password');
		ShowPasswordField('confirm', 'confirm password');
		ShowTextField(true, 'email');
		echo"<input type='submit' name = 'create' value='Create Account'>
			</form>";

	}

	function LoginForm(){
		$errors = array();
		// var_dump($_REQUEST);
		if(isset($_REQUEST['login'])){		//NOT PASSING THROUGH IF
			// var_dump($_REQUEST);
			$errors+=ValidateTextField('username', $errors);
			$errors+=ValidateTextField('password', $errors);

			if(UserExists($_REQUEST['username'])){
				if(GetUser($_REQUEST['username'])['password'] != $_REQUEST['password']){
					$errors['match'] = 'incorrect password!';
				}
			}else{
				$errors['DNE'] = 'user does not exist!';
			}

			if(sizeof($errors) == 0){
				$_SESSION['username'] = $_REQUEST['username'];
				$_SESSION['userID'] = GetUser($_REQUEST['username'])['UserID'];
				header("Location: index.php");
				exit();
			}else{
				// var_dump($errors);
				foreach($errors as $key=>$error){
					DisplayError($key, $error);
				}
				// if(isset($errors['username'])){
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
	}

	function IsLoggedIn(){
		if(isset($_SESSION['username'])){
			return true;
		}
		return false;
	}

	function PersonalHeading(){
		echo"
			<p class='personal'>hi ".$_SESSION['username']."</p>
		";
		Logout();
	}

	function Logout(){
		if(isset($_REQUEST['logout'])){
			// echo"<script>
			// 		alert('Are you sure you want to log out?')
			// 	</script>
			// ";
			session_destroy();
			header("Location: index.php");
			exit();
		}
		echo"
			<form>
				<input class='personal' type='submit' name='logout' value='Log Out'>
			</form>
		";
	}

	function ValidDelete($postID){
		if(isset($_SESSION['username'])){
			if($_SESSION['username'] == GetPost($postID)['username']){
				return true;
			}
			if(GetUser($_SESSION['username'])['userType'] == 'admin'){
				return true;
			}
		}
		return false;
	}

	//USER DATABASE FUNCTIONS
	function AddNewUser($username, $password, $email){
		$result = dbQuery("
			INSERT INTO users (username, password, userType, email)
			VALUES('$username', '$password', 'regUser', '$email')
		")->fetch();
	}

	function UserExists($username){
		$result = dbQuery("
			SELECT *
			FROM users
			WHERE username = '$username'
		")->fetch();
		if(!$result){
			return false;
		}
		return true;
	}

	function UserEmailExists($email){
		$result = dbQuery("
			SELECT *
			FROM users
			WHERE email = '$email'
		")->fetch();
		if(!$result){
			return false;
		}
		return true;
	}

	function GetUser($username){
		$result = dbQuery("
			SELECT *
			FROM users
			WHERE username = '$username'
		")->fetch();
		return $result;
	}

	//BLOG DATABASE FUNCTIONS
	function InsertBlogPost($author, $title, $body){
		if(!$author){
			$author = 'Anonymous';
		}
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, username)
			VALUES('$author', '$title', '$body', 'blog', '$_SESSION[username]')
		")->fetch();
	}

	function GetAllBlogPosts(){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE postType='blog'
		")->fetchAll();
		return $result;
	}

	function DisplayPost($post){
		echo"
		<html>
			<head>
				<title>".$post['title']."</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>".$post['title']."</h1>
				<h2>by ".$post['author']."</h2>
				<h3>date: ".$post['date']."</h3>
				<div>
					<p>".$post['body']."</p><br>
				</div>";
		if(ValidDelete($post['postID'])){
			ShowDelete($post['postID']);
		}
		echo		"
			</body>
		</html>
		";
	}

	function GetNumberPosts(){
		$result = dbQuery("
				SELECT COUNT(postID) AS count
				FROM posts
				WHERE postType='blog'
			")->fetch();
		return $result['count'];
	}


	//PIC DATABASE FUNCTIONS
	function InsertPic($photographer, $title, $body, $link, $flavor){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, link, flavor, username)
			VALUES('$photographer', '$title', '$body', 'pic','$link', '$flavor', '$_SESSION[username]')
		")->fetch();
	}

	function GetAllPics(){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE postType='pic'
		")->fetchAll();
		return $result;
	}

	function DisplayPic($pic){
		echo"
		<html>
			<head>
				<title>".$pic['title']."</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>".$pic['title']."</h1>
				<h2>by ".$pic['author']."</h2>
				<h3>date: ".$pic['date']."</h3>
				<div>
					<img src='".$pic['link']."'alt='".$pic['flavor']."'>
				</div>";
				if($pic['body']!=null){
					echo"<p>".$pic['body']."</p><br>";
				}
		echo"<br>";
		if(ValidDelete($pic['postID'])){
			ShowDelete($pic['postID']);
		}
		echo"
			</body>
		</html>
		";
	}

	function GetNumberPics(){
		$result = dbQuery("
				SELECT COUNT(postID) AS count
				FROM posts
				WHERE postType='pic'
			")->fetch();
		return $result['count'];
	}

	//GENERIC POST DATABASE FUNCTIONS

	function GetPost($postID){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE postID = $postID
		")->fetch();
		return $result;
	}

	function DeletePost($postID){
		$result = dbQuery("
			DELETE FROM posts
			WHERE postID = $postID
		")->fetch();
		echo"Post Deleted.<br>";
		ResetAuto(GetTotalPosts());
	}

	function GetPostType($postID){
		return GetPost($postID)['postType'];
	}

	function GetTotalPosts(){
		$result = dbQuery("
			SELECT MAX(postID) AS count
			FROM posts
		")->fetch();
		return $result['count'];
	}

	function ResetAuto($count){
		$result = dbQuery("
			ALTER TABLE posts
			AUTO_INCREMENT=$count
		")->fetch();
	}
