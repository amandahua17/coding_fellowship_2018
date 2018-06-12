<?php //FOR RECORD

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
//
// function CreatePostForm(){
// 	$type=$_REQUEST['type'];
// 	$errors = array();
//
// 	// $tagarray=array();
// 	// var_dump($_REQUEST);
//
// 	if(isset($_REQUEST['tagsub'])){
// 		$_REQUEST['tagString'].=",";
// 		$_REQUEST['tagString'].=$_REQUEST['tags'];
// 		// var_dump($_REQUEST, $tagarray);
// 		echo"tag added!";
// 	}
//
// 	if(isset($_REQUEST['tagString'])){
// 		$tagarray = explode(',', $_REQUEST['tagString']);
// 	}else{
// 		$tagarray = array();
// 	}
// 	if(isset($_REQUEST['button'])){
// 		if($type == 'blog'){
// 			$errors+=ValidateTextField('Title', $errors);
// 			$errors+=ValidateTextField('Body', $errors);
// 			if(sizeof($errors)==0){
// 				InsertBlogPost($_REQUEST['Author'], $_REQUEST['Title'], $_REQUEST['Body'], $tagarray);
// 				header('Location: index.php');
// 				exit();
// 			}
// 		}else if($type == 'pic'){
// 			$errors+=ValidateTextField('Photographer', $errors);
// 			$errors+=ValidateTextField('Title', $errors);
// 			$errors+=ValidateTextField('Link', $errors);
// 			if(sizeof($errors) == 0){
// 				InsertPic($_REQUEST['Photographer'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['Link'], $_REQUEST['Flavortext'], $tagarray);
// 				header('Location: index.php');
// 				exit();
// 			}
// 		}
// 	}
//
// 	Heading("Create Post", "");
//
//
// 	// ShowLoginPage();
// 	// ShowCreateAccountPage();
// 	echo"
// 				<h1>Create Your Own";
// 	if($type == 'pic'){
// 		echo" Picture ";
// 	}else if ($type == 'blog'){
// 		echo" Blog ";
// 	}
// 	echo							"Post</h1>";
//
//
// 	foreach($errors as $key=>$val){
// 		echo"<span style='color: red'>$key is a required field!<br></span>";
// 	}
//
// 	echo"
// 				<br><form method='post' name='form'>";
// 				if($type== 'pic'){
// 					ShowTextField(true, 'Photographer', '');
// 					ShowTextField(true, 'Title', '');
// 					ShowTextField(false, 'Body', '');
// 					ShowTextField(true, 'Link', '');
// 					ShowTextField(false, 'Flavortext', '');
// 					echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";
//
//
// 				}else if($type=='blog'){
// 					ShowTextField(false, 'Author', '');
// 					ShowTextField(true, 'Title', '');
// 					ShowTextField(true, 'Body', '');
// 				}
// 				ShowTagField('form');
// 				ShowHiddenField('tagString', @$_REQUEST['tagString']);
// 				echo"Tags: ";
// 				foreach($tagarray as $tag){
// 					if(($tag!=NULL)&&($tag!=''))
// 					echo" #".$tag;
// 				}
// 				// var_dump(@$_REQUEST['tagString']);
//
//
// 	echo"
// 					<br><input type='submit' name = 'button'>
// 				</form>";
// }
//
// function EditPostForm($postID){
// 	$post = GetPost($postID);
// 	$type = $post['postType'];
// 	$attributes = GetPostAttributeArray($postID);
// 	$errors = array();
// 	$edits = array();
// 	$tagString = '';
//
// 	if(isset($_REQUEST['cancel'])){
// 		if($type == 'pic'){
// 			header("Location: /view_pic.php?postID=".$postID);
// 			exit();
// 		}else if($type == 'blog'){
// 			header("Location: /view_post.php?postID=".$postID);
// 			exit();
// 		}
// 	}
//
// 	if(isset($_REQUEST['tagsub'])){
// 		$_REQUEST['tagString'].=",";
// 		$_REQUEST['tagString'].=$_REQUEST['tags'];
// 		// var_dump($_REQUEST, $tagarray);
// 		echo"tag added!";
// 	}
//
// 	if(isset($_REQUEST['deleteTag'])){
// 		// var_dump($_REQUEST);
// 		DeleteTagFromPost(GetTag($_REQUEST['deleteTag'])['tagID'], $postID);
// 	}
//
// 	if(isset($_REQUEST['tagString'])){
// 		$tagarray = explode(',', $_REQUEST['tagString']);
// 	}else{
// 		// $tagString = implode(',', GetAllTags($postID)['Array']);
// 		foreach(GetAllTags($postID) as $key=>$val){
// 			$tagString.=",";
// 			$tagString.=$val['tagname'];
// 		}
// 		$tagarray = explode(',', $tagString);
// 	}
//
// 	if(isset($_REQUEST['apply'])){
// 		if($type == 'pic'){
// 			$errors+=ValidateTextField('Photographer', $errors);
// 			$errors+=ValidateTextField('Title', $errors);
// 			$errors+=ValidateTextField('Link', $errors);
// 		}else if($type == 'blog'){
// 			$errors+=ValidateTextField('Title', $errors);
// 			$errors+=ValidateTextField('Body', $errors);
// 		}
// 		if(sizeof($errors) == 0){
// 			var_dump($_REQUEST);
// 			// var_dump($attributes, $_REQUEST);
// 			// die();
// 			// foreach($attributes as $key=>$attribute){
// 			// 	// var_dump($edits, $_REQUEST);
// 			// 	if($type == 'pic'){
// 			// 		if($attribute == 'Author'){		//must add exceptions
// 			// 			$edits['author'] = $_REQUEST['Photographer'];
// 			// 		}else if($attribute == 'Flavortext'){
// 			// 			$edits['flavor'] = $_REQUEST['Flavortext'];
// 			// 		}else{
// 			// 			$edits[$attribute] = $_REQUEST[$attribute];
// 			// 		}
// 			// 	}else{
// 			// 		$edits[$attribute] = $_REQUEST[$attribute];
// 			// 	}
// 			// }
//
// 			foreach($attributes as $key=>$attribute){
// 		   	//var_dump($edits, $_REQUEST);
// 		   	if($type == 'pic'){
// 		   		if($attribute == 'Author'){		//must add exceptions
// 		   			$_REQUEST['author'] = $_REQUEST['Photographer'];
// 		   		}else if($attribute == 'Flavortext'){
// 		   			$_REQUEST['flavor'] = $_REQUEST['Flavortext'];
// 		   		}else{
// 		   			$_REQUEST[$attribute] = $_REQUEST[$attribute];
// 		   		}
// 		   	}
// 		   }
// 			EditPost($postID, $_REQUEST, $tagarray);
// 			if($type == 'pic'){
// 				header("Location: /view_pic.php?postID=".$postID);
// 				exit();
// 			}else if($type == 'blog'){
// 				header("Location: /view_post.php?postID=".$postID);
// 				exit();
// 			}
// 		}
// 	}
//
// 	if(isset($_REQUEST['tagID'])){
// 		DeleteTagFromPost($_REQUEST['tagID'], $postID);
// 		header("Location: /edit_post.php?postID=".$postID);
// 	}
//
// 	//Form
// 	if($type == 'pic'){
// 		Heading("Edit Your Post", "Edit Your Picture Post");
// 	}else if ($type == 'blog'){
// 		Heading("Edit Your Post", "Edit Your Blog Post");
// 	}
// 			foreach($errors as $key=>$val){
// 				echo"<span style='color: red'>$key is a required field!<br></span>";
// 			}
// 	echo"		<form method='post' name='form'>";
// 				if($type== 'pic'){
// 					ShowTextField(true, 'Photographer', $post['author']);
// 					ShowTextField(true, 'Title', $post['title']);
// 					ShowTextField(false, 'Body', $post['body']);
// 					ShowTextField(true, 'Link', $post['link']);
// 					ShowTextField(false, 'Flavortext', $post['flavor']);
// 					echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";
//
//
// 				}else if($type=='blog'){
// 					ShowTextField(false, 'Author', $post['author']);
// 					ShowTextField(true, 'Title', $post['title']);
// 					ShowTextField(true, 'Body', $post['body']);
// 				}
// 				ShowTagField('form');
// 				if(isset($_REQUEST['tagString'])){
// 					// var_dump($_REQUEST['tagString']);
// 					ShowHiddenField('tagString', @$_REQUEST['tagString']);
// 				}else{
// 					// var_dump($tagString);
// 					ShowHiddenField('tagString', @$tagString);
// 				}
// 				echo"<p>Tags: </p>";
// 				// global $j;
// 				// $j=0;
// 				foreach($tagarray as $tag){
// 					if(($tag!='')&&($tag!= NULL)){
// 						echo"<span id='tag'>#".$tag;
// 						echo" <a class='close' href='/edit_post.php?postID=".$postID."&tagID=".GetTag($tag)['tagID']."'>x</a></span>";
// 						// echo"<button onclick=closeTag() class='close' name='$j'>x</button></span>\t";
// 					}
// 					// $j++;
// 				}
// 	echo"			<br><br><input type='submit' name='apply' value='Apply Edits'><br>
// 					<br><input type='submit' name='cancel' value='Cancel'>
// 				</form>
// 	";
//
// }

// function CreateAccountForm(){
// 	$errors = array();
// 	if(isset($_REQUEST['create'])){
// 		$errors+=ValidateTextField('username', $errors);
// 		$errors+=ValidateTextField('password', $errors);
// 		$errors+=ValidateTextField('confirm', $errors);
// 		$errors+=ValidateTextField('email', $errors);
// 		$errors+=ValidatePasswordConfirmation('password', 'confirm', $errors);
// 		$errors+=ValidateUserTaken($_REQUEST['username'], $_REQUEST['email']);
//
// 		if(sizeof($errors) == 0){
// 			AddNewUser($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email']);
// 			header("Location: /account/login.php");
// 			exit();
// 		}else{
// 			foreach($errors as $name=>$error){
// 				DisplayError($name, $error);
// 			}
// 		}
// 	}
//
// 	echo"
// 		<form method='post'>
// 	";
// 	ShowTextField(true, 'username');
// 	ShowPasswordField('password', 'password');
// 	ShowPasswordField('confirm', 'confirm password');
// 	ShowTextField(true, 'email');
// 	echo"<input type='submit' name = 'create' value='Create Account'>
// 		</form>";
//
// }

// function LoginForm(){
// 	$errors = array();
// 	// var_dump($_REQUEST);
// 	if(isset($_REQUEST['login'])){
// 		// var_dump($_REQUEST);
// 		$errors+=ValidateTextField('password', $errors);
// 		$errors+=ValidateTextField('username', $errors);
// 		if(!isset($errors['username'])&&UserExists($_REQUEST['username'])){
// 			if(GetUser($_REQUEST['username'])['password'] != $_REQUEST['password']){
// 				$errors['match'] = 'incorrect password!';
// 			}
// 			$errors+=ValidateActive($_REQUEST['username'], $errors);
// 		}else{
// 			$errors['DNE'] = 'user does not exist!';
// 		}
//
// 		if(sizeof($errors) == 0){
// 			// var_dump($_REQUEST, GetUser($_REQUEST['username'])['userID']);
// 			// die();
// 			$_SESSION['username'] = $_REQUEST['username'];
// 			$_SESSION['userID'] = GetUser($_REQUEST['username'])['userID'];
// 			if(HasNickname($_SESSION['userID'])){
// 				$_SESSION['nickname'] = GetUser($_REQUEST['username'])['nickname'];
// 			}
// 			header("Location: /index.php");
// 			exit();
// 		}else{
// 			// var_dump($errors);
// 			foreach($errors as $key=>$error){
// 				DisplayError($key, $error);
// 			}
// 			// if(isset($errors)){
// 			// 	echo"<div class='required'>Please enter your username.</div>";
// 			// }
// 			// if(isset($errors['password'])){
// 			// 	echo"<div class='required'>Please enter your password.</div>";
// 			// }
// 			// if(isset($errors['match'])){
// 			// 	echo"<div class='required'>Your username and password do not match.</div>";
// 			// }
// 			// if(isset($errors['DNE'])){
// 			// 	echo"<div class='required'>There is no account associated with that username.</div>";
// 			// }
// 		}
// 	}
// 	echo"<form method='post'>";
// 	ShowTextField(true, 'username');
// 	ShowPasswordField('password', 'password');
// 	echo"<input type='submit' name = 'login' value='Login'>
// 		</form>";
// }

// function SettingsForm(){
// 	$val = '';
// 	if(isset($_REQUEST['option'])){
// 		$val = $_REQUEST['option'];
// 	}
// 	echo"
// 		<form method='post'>
// 			<select name='setting'>";
// 	echo"		<option value='0'";
// 	if($val == 0){
// 		echo" selected";
// 	}
// 	echo">-</option>
// 				<option value='1'";
// 	if($val == 1){
// 		echo" selected";
// 	}
// 	echo">Change Username</option>
// 				<option value='2'";
// 	if($val == 2){
// 		echo" selected";
// 	}
// 	echo">Change Password</option>
// 				<option value='3'";
// 	if($val == 3){
// 		echo" selected";
// 	}
// 	echo">Add/Change Nickname</option>
// 				<option value='4'";
// 	if($val == 4){
// 		echo" selected";
// 	}
// 	echo">Deactivate Account</option>
// 			</select><br><br>
// 			<input type='submit' value='Go' name='sub'>
// 		</form>
//
// 	";
// }

// function GetTheme($userID){
// 	$result = dbQuery("
// 		SELECT *
// 		INNER JOIN themes
// 		ON users AS themes.themeID = users.themeID
// 		WHERE userID = :userID
// 	", array('userID'=>$userID))->fetch();
// 	return $result;
// }
//
// function GetBlogColor($userID){
// 	$result = dbQuery("
// 		SELECT blogColor
// 		INNER JOIN themes
// 		ON users AS themes.themeID = users.themeID
// 		WHERE userID = :userID
// 	", array('userID'=>$userID))->fetch();
// 	return $result;
// }
//
// function GetPicColor($userID){
// 	$result = dbQuery("
// 		SELECT picColor
// 		INNER JOIN themes
// 		ON users AS themes.themeID = users.themeID
// 		WHERE userID = :userID
// 	", array('userID'=>$userID))->fetch();
// 	return $result;
// }
//
// function GetUserColor($userID){
// 	$result = dbQuery("
// 		SELECT userColor
// 		INNER JOIN themes
// 		ON users AS themes.themeID = users.themeID
// 		WHERE userID = :userID
// 	", array('userID'=>$userID))->fetch();
// 	return $result;
// }
//
// function GetHeaderPic($userID){
// 	$result = dbQuery("
// 		SELECT headerPic
// 		INNER JOIN themes
// 		ON users AS themes.themeID = users.themeID
// 		WHERE userID = :userID
// 	", array('userID'=>$userID))->fetch();
// 	return $result;
// }
//
// function ChangeTheme($new){
// 	$result = dbQuery("
// 		UPDATE users
// 		SET themeID = :new
// 		WHERE userID = :userID
// 	", array('new'=>$new, 'userID'=>$_SESSION['userID']))->fetch();
// 	return $result;
// }
//
// function GetDefaultTheme(){
// 	$result = dbQuery("
// 		SELECT *
// 		FROM themes
// 		WHERE themeID = 1
// 	")->fetch();
// 	return $result;
// }
//
// //OTHER FUNCTIONS
// function GetCurrentTheme(){
// 	return $_SESSION['themeID'];
// }
