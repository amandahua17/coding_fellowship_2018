
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

	function CreateAccountPage(){
		echo"
			<a href='createAccount.php'>Create an account</a><br>
		";
	}


	//FORM FUNCTIONS
	function ValidateTextField($key, $errors){
		if(!$_REQUEST[$key]){
			$errors[$key] = "required";
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

	function ShowTagField(){
		echo"
			<p >tags:</p><input type='text' name='tags'>
			<input type='submit' name='tagsub' value='add tag'>
			<br><br>
		";
	}

	//USER FUNCTIONS
	function CreateAccount(){
		$errors = array();
		if(isset($_REQUEST['create'])){
			$errors+=ValidateTextField('username', $errors);
			$errors+=ValidateTextField('password', $errors);
			$errors+=ValidateTextField('confirm', $errors);
			$errors+=ValidateTextField('email', $errors);
			if((!isset($errors['password']))&&(!isset($errors['confirm']))){
				if($_REQUEST['password'] != $_REQUEST['confirm']){
					$errors['match'] = 'error';
				}
			}
			if(sizeof($errors) == 0){
				AddNewUser($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email']);
				header("Location: login.php");
			}else{
				if(isset($errors['username'])){
					echo"<div class='required'>Please enter your username.</div>";
				}
				if(isset($errors['password'])){
					echo"<div class='required'>Please enter your password.</div>";
				}
				if(isset($errors['confirm'])){
					echo"<div class='required'>Please confirm your password.</div>";
				}
				if(isset($errors['password'])){
					echo"<div class='required'>Please enter your email.</div>";
				}
				if(isset($errors['match'])){
					echo"<div class='required'>Your passwords do not match.</div>";
				}
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

	function Login(){
		$errors = array();
		// var_dump($_REQUEST);
		if(isset($_REQUEST['login'])){		//NOT PASSING THROUGH IF
			// var_dump($_REQUEST);
			$errors+=ValidateTextField('username', $errors);
			$errors+=ValidateTextField('password', $errors);
			if(sizeof($errors) == 0){
				if(UserExists($_REQUEST['username'])){
					if(GetUser($_REQUEST['username'])['password'] != $_REQUEST['password']){
						$errors['match'] = 'incorrect password!';
					}
				}else{
					$errors['DNE'] = 'user does not exist!';
				}
			}
			if(sizeof($errors) == 0){
				$_SESSION['username'] = $_REQUEST['username'];
				header("Location: index.php");
			}else{
				if(isset($errors['username'])){
					echo"<div class='required'>Please enter your username.</div>";
				}
				if(isset($errors['password'])){
					echo"<div class='required'>Please enter your password.</div>";
				}
				if(isset($errors['match'])){
					echo"<div class='required'>Your username and password do not match.</div>";
				}
				if(isset($errors['DNE'])){
					echo"<div class='required'>There is no account associated with that username.</div>";
				}
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

	//TAG DATABASE FUNCTIONS
	function NewTag($name){
		dbQuery("
			INSERT INTO tags (tagname)
			VALUES('$name')
		")->fetch();
	}

	function AttachTags($postID, $tagnamearray){
		echo"attachtags called";
		foreach($tagnamearray as $key=>$tagname){
		echo"forloop";
			if(!TagExists($tagname)){
				echo"<br>CREATING A NEW TAG<br>";
				NewTag($tagname);
			}
			$tagID=GetTag($tagname)['tagID'];
			dbQuery("
				INSERT INTO posttags (postID, tagID)
				VALUES('$postID', '$tagID')
			")->fetchAll();
		}
		die("attachtags done");
	}

	function GetTag($name){
		$result=dbQuery("
			SELECT *
			FROM tags
			WHERE tagname = '$tagID'
		")->fetch();
		return $result;
	}

	function GetAllTags($postID){		//CONFIRM SYNTAX OF DBQUERY
		$result=dbQuery("
			SELECT tagname
			FROM tags
			WHERE tagID =
			(SELECT tagID FROM posttags WHERE postID = '$postID')
		")->fetchAll();
		return $result;
	}

	function HasTags($postID){
		$result = dbQuery("
			SELECT *
			FROM posttags
			WHERE EXISTS
			(SELECT 1 FROM posttags
			WHERE postID = '$postID')
		")->fetch();
		return $result;
	}

	function TagExists($name){		//NOT GETTING CALLED
	echo"tagexists called";
		$result = dbQuery("
			SELECT *
			FROM tags
			WHERE EXISTS
			(SELECT 1 FROM tags
			WHERE tagname = '$name')
		")->fetch();
		return $result;
	}

	function ShowTags($postID){
		if(HasTags($postID)){
			echo"Tags: ";
			foreach(GetAllTags($postID) as $key=>$tagname){
				echo"#$tagname";
			}
		}
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
			WHERE EXISTS
			(SELECT 1 FROM users
			WHERE username = '$username')
		")->fetch();
		return $result;
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
	function InsertBlogPost($author, $title, $body, $tagarray){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, username)
			VALUES('$author', '$title', '$body', 'blog', '$_SESSION[username]')
		")->fetch();
		var_dump($tagarray);
		AttachTags(GetRecentPost()['postID'], $tagarray);
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
		ShowTags($post['postID']);
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
	function InsertPic($photographer, $title, $body, $link, $flavor, $tagarray){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, link, flavor, username)
			VALUES('$photographer', '$title', '$body', 'pic','$link', '$flavor', '$_SESSION[username]')
		")->fetch();
		var_dump($tagarray);
		AttachTags(GetRecentPost()['postID'], $tagarray);
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
		ShowTags($pic['postID']);
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

	function GetRecentPost(){
		$result = dbQuery("
			SELECT *, MAX(postID)
			AS recentpost
			FROM posts
		")->fetch();
		return $result['recentpost'];
	}
