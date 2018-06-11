
<?php

	//RANDOM FUNCTIONS
	function Heading($title, $h1){
		echo"
			<html>
				<header>
					<title>$title</title>
					<link rel='stylesheet' href='/style/mainstyle.css'>
					<script src='/js/jquery-3.3.1.min.js'></script>
				</header>
				<body>";
		if(IsLoggedIn()){
			PersonalHeading();
		}
		if(!IsLoggedIn()){
			ShowLoginPage();
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

	function Home(){
		echo"
			<a class='home' href='/index.php'>back to home</a>
		</html>";
	}

	function ShowDelete($postID){
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

	function ShowEdit($postID){
		// echo"ShowEdit called";
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
		<input type='hidden' name='$name' value='".addslashes($value)."'><br>
		";
	}

	function EditPostForm($postID){
		$post = GetPost($postID);
		$type = $post['postType'];
		$attributes = GetPostAttributeArray($postID);
		$errors = array();
		$edits = array();
		$tagString = '';

		if(isset($_REQUEST['cancel'])){
			if($type == 'pic'){
				header("Location: /view_pic.php?postID=".$postID);
				exit();
			}else if($type == 'blog'){
				header("Location: /view_post.php?postID=".$postID);
				exit();
			}
		}

		if(isset($_REQUEST['tagsub'])){
			$_REQUEST['tagString'].=",";
			$_REQUEST['tagString'].=$_REQUEST['tags'];
			// var_dump($_REQUEST, $tagarray);
			echo"tag added!";
		}

		if(isset($_REQUEST['deleteTag'])){
			// var_dump($_REQUEST);
			DeleteTagFromPost(GetTag($_REQUEST['deleteTag'])['tagID'], $postID);
		}

		if(isset($_REQUEST['tagString'])){
			$tagarray = explode(',', $_REQUEST['tagString']);
		}else{
			// $tagString = implode(',', GetAllTags($postID)['Array']);
			foreach(GetAllTags($postID) as $key=>$val){
				$tagString.=",";
				$tagString.=$val['tagname'];
			}
			$tagarray = explode(',', $tagString);
		}

		if(isset($_REQUEST['apply'])){
			if($type == 'pic'){
				$errors+=ValidateTextField('Photographer', $errors);
				$errors+=ValidateTextField('Title', $errors);
				$errors+=ValidateTextField('Link', $errors);
			}else if($type == 'blog'){
				$errors+=ValidateTextField('Title', $errors);
				$errors+=ValidateTextField('Body', $errors);
			}
			if(sizeof($errors) == 0){
				var_dump($_REQUEST);
				// var_dump($attributes, $_REQUEST);
				// die();
				// foreach($attributes as $key=>$attribute){
				// 	// var_dump($edits, $_REQUEST);
				// 	if($type == 'pic'){
				// 		if($attribute == 'Author'){		//must add exceptions
				// 			$edits['author'] = $_REQUEST['Photographer'];
				// 		}else if($attribute == 'Flavortext'){
				// 			$edits['flavor'] = $_REQUEST['Flavortext'];
				// 		}else{
				// 			$edits[$attribute] = $_REQUEST[$attribute];
				// 		}
				// 	}else{
				// 		$edits[$attribute] = $_REQUEST[$attribute];
				// 	}
				// }

				foreach($attributes as $key=>$attribute){
			   	//var_dump($edits, $_REQUEST);
			   	if($type == 'pic'){
			   		if($attribute == 'Author'){		//must add exceptions
			   			$_REQUEST['author'] = $_REQUEST['Photographer'];
			   		}else if($attribute == 'Flavortext'){
			   			$_REQUEST['flavor'] = $_REQUEST['Flavortext'];
			   		}else{
			   			$_REQUEST[$attribute] = $_REQUEST[$attribute];
			   		}
			   	}
			   }
				EditPost($postID, $_REQUEST, $tagarray);
				if($type == 'pic'){
					header("Location: /view_pic.php?postID=".$postID);
					exit();
				}else if($type == 'blog'){
					header("Location: /view_post.php?postID=".$postID);
					exit();
				}
			}
		}

		if(isset($_REQUEST['tagID'])){
			DeleteTagFromPost($_REQUEST['tagID'], $postID);
			header("Location: /edit_post.php?postID=".$postID);
		}

		//Form
		if($type == 'pic'){
			Heading("Edit Your Post", "Edit Your Picture Post");
		}else if ($type == 'blog'){
			Heading("Edit Your Post", "Edit Your Blog Post");
		}
				foreach($errors as $key=>$val){
					echo"<span style='color: red'>$key is a required field!<br></span>";
				}
		echo"		<form method='post' name='form'>";
					if($type== 'pic'){
						ShowTextField(true, 'Photographer', $post['author']);
						ShowTextField(true, 'Title', $post['title']);
						ShowTextField(false, 'Body', $post['body']);
						ShowTextField(true, 'Link', $post['link']);
						ShowTextField(false, 'Flavortext', $post['flavor']);
						echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";


					}else if($type=='blog'){
						ShowTextField(false, 'Author', $post['author']);
						ShowTextField(true, 'Title', $post['title']);
						ShowTextField(true, 'Body', $post['body']);
					}
					ShowTagField();
					if(isset($_REQUEST['tagString'])){
						// var_dump($_REQUEST['tagString']);
						ShowHiddenField('tagString', @$_REQUEST['tagString']);
					}else{
						// var_dump($tagString);
						ShowHiddenField('tagString', @$tagString);
					}
					echo"<p>Tags: </p>";
					// global $j;
					// $j=0;
					foreach($tagarray as $tag){
						if(($tag!='')&&($tag!= NULL)){
							echo"<span id='tag'>#".$tag;
							echo" <a class='close' href='/edit_post.php?postID=".$postID."&tagID=".GetTag($tag)['tagID']."'>x</a></span>";
							// echo"<button onclick=closeTag() class='close' name='$j'>x</button></span>\t";
						}
						// $j++;
					}
		echo"			<br><br><input type='submit' name='apply' value='Apply Edits'><br>
						<br><input type='submit' name='cancel' value='Cancel'>
					</form>
				</body>
			</html>
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
			if(GetUser($_SESSION['username'])['userType'] == 'admin'){
				return true;
			}
		}
		// if(GetPostCreator($postID) == NULL){
		// 	return true;
		// }
		return false;
	}

	//TAG DATABASE FUNCTIONS
	function DeleteTagFromPost($tagID, $postID){
		$result = dbQuery("
			DELETE FROM posttags
			WHERE tagID = :tagID
			AND postID = :postID
		", array('tagID'=>$tagID, 'postID'=>$postID))->fetch();
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
				// echo"<br>CREATING A NEW TAG<br>";
				NewTag($tagarray[$i]);
			}
			$tagID=GetTag($tagarray[$i])['tagID'];
			// if(!TagDuplicate($postID, $tagID)){
			dbQuery("
				REPLACE INTO posttags (postID, tagID)
				VALUES(:postID, :tagID)
			", array('postID'=>$postID, 'tagID'=>$tagID))->fetchAll();
			// }
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

	function GetAllTags($postID){
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
			WHERE postID = :postID
		", array('postID'=>$postID))->fetchAll();
		// var_dump($result);
		if(!$result){
			return false;
		}
		return true;
	}

	function TagExists($name){
		echo"tagexists called";
		$result = dbQuery("
			SELECT *
			FROM tags
			WHERE tagname = :name
		", array('name'=>$name))->fetchAll();
		if(!$result){
			return false;
		}
		return true;
	}

	function ShowTags($tagarray){

		echo"<p>Tags: </p>";
		foreach($tagarray as $tag){
			$tagID = GetTag($tag['tagname'])['tagID'];
			echo"<span id='tag'><a class='tag' href='/view_tag.php?tagID=".$tagID."'>#".$tag['tagname']."</a></span>
			\t";
		}
		echo"<br><br><form><input onclick='textColor()' type='button' value='Change Text Color'></form>

			<script src='/include/jsFunctions.js'> </script>
		";
	}

	function GetPostsWithTag($tagID){		//CONFIRM SYNTAX OF DBQUERY
		$result = dbQuery("
			SELECT *
			FROM posts
			INNER JOIN posttags
			ON posts.postID = posttags.postID
			WHERE posttags.tagID = :tagID
		", array('tagID'=>$tagID))->fetchAll();
		return $result;
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
		// var_dump($author, $title, $body, $_SESSION);
		dbQuery("
			INSERT INTO posts (author, title, body, postType, userID)
			VALUES(:author, :title, :body, 'blog', '$_SESSION[userID]')
		", array('author'=>$author, 'title'=>addslashes($title), 'body'=>addslashes($body)))->fetch();
		$result = GetLastPostID();
		// var_dump($result);
		// die("Blog Post should be inserted by now");
		AttachTags($result['postID'], $tagarray);
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
		if(HasTags($post['postID'])){
			ShowTags(GetAllTags($post['postID']));
		}
		if(HasEditPermission($post['postID'])){
			ShowEdit($post['postID']);
		}
		if(HasDeletePermission($post['postID'])){
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
		dbQuery("
		INSERT INTO posts (author, title, body, postType, link, flavor, userID)
		VALUES(:photographer, :title, :body, 'pic',:link, :flavor, '$_SESSION[userID]')
		", array('photographer'=>$photographer, 'title'=>$title, 'body'=>$body, 'link'=>$link, 'flavor'=>$flavor))->fetch();
		$result = GetLastPostID();
		AttachTags($result['postID'], $tagarray);
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
		if(HasTags($pic['postID'])){
			ShowTags(GetAllTags($pic['postID']));
		}
		if(HasEditPermission($pic['postID'])){
			ShowEdit($pic['postID']);
			// var_dump($pic['postID']);
		}
		if(HasDeletePermission($pic['postID'])){
			ShowDelete($pic['postID']);
		}
		echo"
			</body>
		</html>
		";
	}

	//GENERIC POST DATABASE FUNCTIONS
	function GetLastPostID(){
		$result = dbQuery("
			SELECT LAST_INSERT_ID() as postID;
		")->fetch();
		return $result;
	}

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
		// var_dump($result);
		return $result['recentpost'];
	}

	function EditPost($postID, $changes, $tagarray){
		// var_dump($changes);
		// die();
		$type = GetPost($postID)['postType'];
		// echo"EditPost Called!";
		// var_dump($changes);
		// foreach($changes as $column=>$change){
			// var_dump($column, $change);
			// var_dump($changes, $type);
			// die();
		if($type == 'pic'){
			dbQuery("
				UPDATE posts
				SET author = :phot, title = :title, body = :body, link = :link, flavor = :flavor
				WHERE postID = :postID
			", array('phot'=>$changes['Author'],
					'title'=>$changes['Title'],
					'body'=>$changes['Body'],
					'link'=>$changes['Link'],
					'flavor'=>$changes['Flavor'],
					'postID'=>$postID))->fetchAll();
		}else if ($type == 'blog'){

			dbQuery("
				UPDATE posts
				SET author = :author, title = :title, body = :body
				WHERE postID = :postID
			", array('author'=>$changes['Author'],
					'title'=>$changes['Title'],
					'body'=>$changes['Body'],
					'postID'=>$postID))->fetchAll();
		}
		// }
		AttachTags($postID, $tagarray);
	}

	function GetPostAttributeArray($postID){
		$result = array();
		$type = GetPost($postID)['postType'];
		$placeholder = dbQuery("
			SELECT *
			FROM typeattributes
			INNER JOIN posttypes ON typeattributes.typeID = posttypes.typeID
			WHERE posttypes.postType = :type
		", array('type'=>$type))->fetch();
		foreach($placeholder as $key=>$val){
			if($val != NULL){
				if(($key != 'typeID')&&($key != 'postType'))
				$result[$key] = $placeholder[$key];
			}
		}
		// var_dump($result);
		return $result;
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

	// function TagDuplicate($postID, $tagID){
	// 	$result = dbQuery("
	// 		SELECT *
	// 		FROM posttags
	// 		WHERE postID = :postID
	// 		AND tagID = :tagID
	// 	", array('postID'=>$postID, 'tagID'=>$tagID))->fetchAll();
	// 	if(!$result){
	// 		return false;
	// 	}
	// 	return true;
	// }
