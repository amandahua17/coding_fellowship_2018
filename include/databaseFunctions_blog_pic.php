
<?php

	//RANDOM FUNCTIONS
	function Home(){
		echo"
			<a class='home' href='/index.php'>back to home</a>
			";
	}

	function ShowDelete($postID){
		if(isset($_REQUEST['delete'])){
			if(ValidDelete($postID)){
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

	function ShowLoginPage(){
		echo"
			<a href='/account/login.php'>Log In</a><br>
		";
	}

	function ShowCreateAccountPage(){
		echo"
			<a href='/account/createAccount.php'>Create an account</a><br>
		";
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

	function ShowTagField(){
		echo"
			<p >tags:</p><input type='text' name='tags'>
			<input type='submit' name='tagsub' value='add tag'>
			<br><br>
		";
	}

	function ShowHiddenField($name, $value){
		echo"
		<input type='hidden' name='$name' value=$value><br>
		";
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
				header("Location: /login.php");
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
				// var_dump($_REQUEST, GetUser($_REQUEST['username'])['userID']);
				// die();
				$_SESSION['username'] = $_REQUEST['username'];
				$_SESSION['userID'] = GetUser($_REQUEST['username'])['userID'];
				header("Location: /index.php");
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
		echo"";
		if(isset($_SESSION['userID'])){
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
			header("Location: /index.php");
			exit();
		}
		echo"
			<form>
				<input class='personal' type='submit' name='logout' value='Log Out'>
			</form>
		";
	}

	function ValidDelete($postID){
		// echo"validdelete called";
		// var_dump($_SESSION);
		if(isset($_SESSION['userID'])){
			if($_SESSION['userID'] == GetPostCreator($postID)){
				return true;
			}
			if(GetUser($_SESSION['username'])['userType'] == 'admin'){
				return true;
			}
		}
		if(GetPostCreator($postID) == NULL){
			return true;
		}
		return false;
	}

	//TAG DATABASE FUNCTIONS
	function DeleteTagFromPost($tagname, $postID){		//CHECK DBQUERY SYNTAX
		$result = dbQuery("
			DELETE FROM posttags
			WHERE (SELECT tagname
				FROM tags
				INNER JOIN posttags ON
				tags.tagID = posttags.tagID) = :tagname
			AND postID = :postID
		", array('tagname'=>$tagname, 'postID'=>$postID))->fetch();
	}

	function DeleteTagOverall($name){
		$result = dbQuery("
			DELETE FROM tags
			WHERE tagname = :name
		", array('name'=>$name))->fetch();
	}

	function NewTag($name){
		dbQuery("
			INSERT INTO tags (tagname)
			VALUES(:name)
		", array('name'=>$name))->fetch();
	}

	function AttachTags($postID, $tagarray){
		// echo"attachtags called, postID: ";
		// var_dump($postID);
		for($i=0;$i<sizeof($tagarray);$i++){
			// die("forloop");
			if(($tagarray[$i] == 'null')||($tagarray[$i] == '')){
				continue;
			}
			if(!TagExists($tagarray[$i])){
				echo"<br>CREATING A NEW TAG<br>";
				NewTag($tagarray[$i]);
			}
			$tagID=GetTag($tagarray[$i])['tagID'];
			dbQuery("
				INSERT INTO posttags (postID, tagID)
				VALUES(:postID, :tagID)
			", array('postID'=>$postID, 'tagID'=>$tagID))->fetchAll();
		}
		 // die();
	}

	function GetTag($name){
		$result=dbQuery("
			SELECT *
			FROM tags
			WHERE tagname = :name
		", array('name'=>$name))->fetch();
		return $result;
	}

	function GetAllTags($postID){		//CONFIRM SYNTAX OF DBQUERY
		$result=dbQuery("
			SELECT tagname
			FROM tags
			INNER JOIN posttags ON tags.tagID = posttags.tagID
			WHERE posttags.postID = :postID
		", array('postID'=>$postID))->fetchAll();
		// var_dump($result);
		return $result;
	}

	function HasTags($postID){
		// echo"HasTags called";
		$result = dbQuery("
			SELECT *
			FROM posttags
			WHERE EXISTS
			(SELECT 1 FROM posttags
			WHERE postID = :postID)
		", array('postID'=>$postID))->fetch();
		// var_dump($result);
		return $result;
	}

	function TagExists($name){		//NOT GETTING CALLED
		echo"tagexists called";
		$result = dbQuery("
			SELECT *
			FROM tags
			WHERE EXISTS
			(SELECT 1 FROM tags
			WHERE tagname = :name)
		", array('name'=>$name))->fetch();
		return $result;
	}

	function ShowTags($postID){
		// echo"ShowTags called";
		if(HasTags($postID)){
			$tagarray = GetAllTags($postID);
			// var_dump($tagarray);
			echo"Tags: ";
			for($i=0;$i<sizeof($tagarray);$i++){
				echo"#".$tagarray[$i]['tagname']."\t";
			}
		}
	}

	//USER DATABASE FUNCTIONS
	function AddNewUser($username, $password, $email){
		$result = dbQuery("
			INSERT INTO users (username, password, userType, email)
			VALUES(:username, :password, 'regUser', :email)
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

	function GetPostCreator($postID){
		return GetPost($postID)['userID'];
	}

	//BLOG DATABASE FUNCTIONS
	function InsertBlogPost($author, $title, $body, $tagarray){
		if(!$author){
			$author = 'Anonymous';
		}
		if(!$_SESSION['userID']){
			$_SESSION['userID'] = NULL;
		}
		var_dump($author, $title, $body, $_SESSION);
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, userID)
			VALUES(:author, :title, :body, 'blog', '$_SESSION[userID]')
		", array('author'=>$author, 'title'=>$title, 'body'=>$body))->fetch();
		// var_dump($result);
		// die("Blog Post should be inserted by now");
		AttachTags(GetTotalPosts(), $tagarray);
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
				<link rel='stylesheet' href='/style/mainstyle.css'>
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
			// echo"valid delete";
			ShowDelete($post['postID']);
		}
		echo		"
			</body>
		</html>
		";
	}



	//PIC DATABASE FUNCTIONS
	function InsertPic($photographer, $title, $body, $link, $flavor, $tagarray){
		if(!$_SESSION['userID']){
			$_SESSION['userID'] = NULL;
		}
		$result = dbQuery("
		INSERT INTO posts (author, title, body, postType, link, flavor, userID)
		VALUES(:photographer, :title, :body, 'pic',:link, :flavor, '$_SESSION[userID]')
		", array('photographer'=>$photographer, 'title'=>$title, 'body'=>$body, 'link'=>$link, 'flavor'=>$flavor))->fetch();

		// var_dump($tagarray);
		AttachTags(GetTotalPosts(), $tagarray);
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
				<link rel='stylesheet' href='/style/mainstyle.css'>
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



	//GENERIC POST DATABASE FUNCTIONS

	function GetPost($postID){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE postID = :postID
		", array('postID'=>$postID))->fetch();
		return $result;
	}

	function DeletePost($postID){
		$result = dbQuery("
			DELETE FROM posts
			WHERE postID = :postID
		", array('postID'=>$postID))->fetch();
		$result = dbQuery("
			DELETE FROM posttags
			WHERE postID = :postID
		", array('postID'=>$postID))->fetch();
		echo"Post Deleted.<br>";
		// ResetAuto(GetTotalPosts());
	}

	function GetPostType($postID){
		return GetPost($postID)['postType'];
	}

	function GetRecentPost(){
		$result = dbQuery("
			SELECT *, MAX(postID)
			AS recentpost
			FROM posts
		")->fetch();
		var_dump($result);
		return $result['recentpost'];
	}

	//REMOVED FUNCTIONS

	// function ResetAuto($count){
	// 	$result = dbQuery("
	// 		ALTER TABLE posts
	// 		AUTO_INCREMENT=:count
	// 	", array('count'=>$count))->fetch();
	// }

	// function GetNumberPosts(){
	// 	$result = dbQuery("
	// 			SELECT COUNT(postID) AS count
	// 			FROM posts
	// 			WHERE postType='blog'
	// 		")->fetch();
	// 	return $result['count'];
	// }

	// function GetNumberPics(){
	// 	$result = dbQuery("
	// 			SELECT COUNT(postID) AS count
	// 			FROM posts
	// 			WHERE postType='pic'
	// 		")->fetch();
	// 	return $result['count'];
	// }

	// function GetTotalPosts(){			IF YOU REVIVE THIS FUNCTION, MAX(postID) is NOT NECESSARILY THE COUNT!!!
	// 	$result = dbQuery("
	// 		SELECT MAX(postID) AS count
	// 		FROM posts
	// 	")->fetch();
	// 	return $result['count'];
	// }
