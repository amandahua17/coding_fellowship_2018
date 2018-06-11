
<?php

	//NOTES:
		//"Show" shows a field, button, or link (home, form, etc.)
		//"Display" shows an element (tag, comment, etc.)

	//RANDOM FUNCTIONS
	function Heading($title, $h1){
		echo"
			<html>
				<header>
					<title>$title</title>
					<link rel='stylesheet' href='/style/mainstyle.css'>
					<script src='/js/jquery.js'></script>
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

	function Footer(){
		echo"
			</body>
		</html>
		";
		Home();
	}

	function Home(){
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
		echo"<a href='/user_settings.php'>User Settings</a><br>";
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

	function ShowTagField($form){
		echo"
			<p >tags:</p><input type='text' name='tags'>
			<input form='$form' type='submit' name='tagsub' value='add tag'>
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
	function CreatePostForm(){
		$type=$_REQUEST['type'];
		$errors = array();

		// $tagarray=array();
		// var_dump($_REQUEST);

		if(isset($_REQUEST['tagsub'])){
			$_REQUEST['tagString'].=",";
			$_REQUEST['tagString'].=$_REQUEST['tags'];
			// var_dump($_REQUEST, $tagarray);
			echo"tag added!";
		}

		if(isset($_REQUEST['tagString'])){
			$tagarray = explode(',', $_REQUEST['tagString']);
		}else{
			$tagarray = array();
		}
		if(isset($_REQUEST['button'])){
			if($type == 'blog'){
				$errors+=ValidateTextField('Title', $errors);
				$errors+=ValidateTextField('Body', $errors);
				if(sizeof($errors)==0){
					InsertBlogPost($_REQUEST['Author'], $_REQUEST['Title'], $_REQUEST['Body'], $tagarray);
					header('Location: index.php');
					exit();
				}
			}else if($type == 'pic'){
				$errors+=ValidateTextField('Photographer', $errors);
				$errors+=ValidateTextField('Title', $errors);
				$errors+=ValidateTextField('Link', $errors);
				if(sizeof($errors) == 0){
					InsertPic($_REQUEST['Photographer'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['Link'], $_REQUEST['Flavortext'], $tagarray);
					header('Location: index.php');
					exit();
				}
			}
		}

		Heading("Create Post", "");


		// ShowLoginPage();
		// ShowCreateAccountPage();
		echo"
					<h1>Create Your Own";
		if($type == 'pic'){
			echo" Picture ";
		}else if ($type == 'blog'){
			echo" Blog ";
		}
		echo							"Post</h1>";


		foreach($errors as $key=>$val){
			echo"<span style='color: red'>$key is a required field!<br></span>";
		}

		echo"
					<br><form method='post' name='form'>";
					if($type== 'pic'){
						ShowTextField(true, 'Photographer', '');
						ShowTextField(true, 'Title', '');
						ShowTextField(false, 'Body', '');
						ShowTextField(true, 'Link', '');
						ShowTextField(false, 'Flavortext', '');
						echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";


					}else if($type=='blog'){
						ShowTextField(false, 'Author', '');
						ShowTextField(true, 'Title', '');
						ShowTextField(true, 'Body', '');
					}
					ShowTagField('form');
					ShowHiddenField('tagString', @$_REQUEST['tagString']);
					echo"Tags: ";
					foreach($tagarray as $tag){
						if(($tag!=NULL)&&($tag!=''))
						echo" #".$tag;
					}
					// var_dump(@$_REQUEST['tagString']);


		echo"
						<br><input type='submit' name = 'button'>
					</form>";
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
					ShowTagField('form');
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
		";

	}

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
				header("Location: /account/login.php");
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
		if(isset($_REQUEST['login'])){
			// var_dump($_REQUEST);
			$errors+=ValidateTextField('password', $errors);
			$errors+=ValidateTextField('username', $errors);
			if(!isset($errors['username'])&&UserExists($_REQUEST['username'])){
				if(GetUser($_REQUEST['username'])['password'] != $_REQUEST['password']){
					$errors['match'] = 'incorrect password!';
				}
				$errors+=ValidateActive($_REQUEST['username'], $errors);
			}else{
				$errors['DNE'] = 'user does not exist!';
			}

			if(sizeof($errors) == 0){
				// var_dump($_REQUEST, GetUser($_REQUEST['username'])['userID']);
				// die();
				$_SESSION['username'] = $_REQUEST['username'];
				$_SESSION['userID'] = GetUser($_REQUEST['username'])['userID'];
				if(HasNickname($_SESSION['userID'])){
					$_SESSION['nickname'] = GetUser($_REQUEST['username'])['nickname'];
				}
				header("Location: /index.php");
				exit();
			}else{
				// var_dump($errors);
				foreach($errors as $key=>$error){
					DisplayError($key, $error);
				}
				// if(isset($errors)){
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

	function SettingsForm(){
		$val = '';
		if(isset($_REQUEST['option'])){
			$val = $_REQUEST['option'];
		}
		echo"
			<form method='post'>
				<select name='setting'>";
		echo"		<option value='0'";
		if($val == 0){
			echo" selected";
		}
		echo">-</option>
					<option value='1'";
		if($val == 1){
			echo" selected";
		}
		echo">Change Username</option>
					<option value='2'";
		if($val == 2){
			echo" selected";
		}
		echo">Change Password</option>
					<option value='3'";
		if($val == 3){
			echo" selected";
		}
		echo">Add/Change Nickname</option>
					<option value='4'";
		if($val == 4){
			echo" selected";
		}
		echo">Deactivate Account</option>
				</select><br><br>
				<input type='submit' value='Go' name='sub'>
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
				header("Location: /user_settings.php?option=6");
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
				ShowTextField(true, 'NewUsername', '');
				ShowPasswordField('password', 'Password');
		echo"
				<input type='submit' name='change'>
			</form>
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
				header("Location: /user_settings.php?option=6");
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
				ShowPasswordField('newpswd', 'New Password');
				ShowPasswordField('confirm', 'Confirm New Password');
				ShowPasswordField('oldpswd', 'Old Password');
		echo"
				<input type='submit' name='change'>
			</form>
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
				header("Location: /user_settings.php?option=6");
				exit();
			}else{
				foreach($errors as $name=>$error){
					DisplayError($name, $error);
				}
			}
		}else{

		}

		echo"
			<form method='post'>
				";
				ShowTextField(true, 'Nickname', '');
				ShowPasswordField('password', 'Password');
		echo"
				<input type='submit' name='change'>
			</form>
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
				header("Location: /user_settings.php?option=5");
				exit();
			}else{
				foreach($errors as $name=>$error){
					DisplayError($name, $error);
				}
			}
		}

		echo"
			<form method='post'>";
				ShowPasswordField('password', 'Password');
		echo"
				<input type='submit' name='delete' value='Deactivate Account'>
			</form>
		";
	}

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
	//COMMENT DATABASE FUNCTIONS
	function AddNewComment($comment, $postID){
		$result=dbQuery("
			INSERT INTO comments (postID, userID, body)
			VALUES (:postID, $_SESSION[userID], :comment)
		", array('postID'=>$postID, 'comment'=>$comment))->fetch();
	}

	function DisplayComments($postID){
		if(isset($_REQUEST['DCommentID'])){
			DeleteComment($_REQUEST['DCommentID']);
		}
		if(isset($_REQUEST['ECommentID'])){
			if(isset($_REQUEST['editcom'.$_REQUEST['ECommentID']])){
				// var_dump($_REQUEST);
				EditComment($_REQUEST['ECommentID'], $_REQUEST['Edit']);
			}else{
				ShowEditComment($_REQUEST['ECommentID']);
			}
		}
		$comments = GetComments($postID);
		$type = GetPostType($postID);
		if($type == 'pic'){
			$url = '/view_pic.php?postID='.$postID;
		}else if ($type == 'blog'){
			$url = '/view_post.php?postID='.$postID;
		}
		if(sizeof($comments)){
			echo"Comments: <br><br>";
		}
		foreach($comments as $comment){
			// var_dump(GetUserWithID($comment['userID'])['username']);
			echo"\t<span style='padding:4px;
			background-color:#eee;'class='comment'>
			<a style='padding:2px;
			font-weight:bold;
			background-color:#ddd;
			color:#fff;'class='userbadge' href='/view_user.php?userID=".$comment['userID']."'>".GetUserWithID($comment['userID'])['username']."</a>
			".$comment['body'];
			if(ValidEditComment($comment['commentID'])){
				echo"\t<a style='color: grey' href='".$url."&DCommentID=".$comment['commentID']."'>delete comment</a>";
				echo"\t<a style='color: grey' href='".$url."&ECommentID=".$comment['commentID']."'>edit comment</a>";
				//PLACE EDIT COMMENT HERE
			}
			echo"</span><br><br>";
		}
		echo"<br><br>";
	}

	function ShowEditComment($commentID){
		echo"
			<form method='post'>";
			ShowTextField(false, 'Edit Comment', GetComment($commentID)['body']);
		echo"
				<input type='submit' name='editcom".$commentID."'>
			</form>
		";
	}

	function GetComments($postID){
		$result=dbQuery("
			SELECT *
			FROM comments
			WHERE postID = :postID
		", array('postID'=>$postID))->fetchAll();
		// var_dump($result);
		return $result;
	}

	function GetComment($commentID){
		$result=dbQuery("
			SELECT *
			FROM comments
			WHERE commentID = :commentID
		", array('commentID'=>$commentID))->fetch();
		// var_dump($result);
		return $result;
	}

	function DeleteComment($commentID){
		$result=dbQuery("
			DELETE FROM comments
			WHERE commentID = :commentID
		", array('commentID'=>$commentID))->fetch();
	}

	function EditComment($commentID, $body){
		$result = dbQuery("
			UPDATE comments
			SET body = :body
			WHERE commentID = :commentID
		", array('body'=>$body, 'commentID'=>$commentID))->fetch();
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

	function DisplayTags($tagarray){

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

	function GetPostsWithTag($tagID){
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

	function GetPostCreator($postID){
		return GetPost($postID)['userID'];
	}

	function GetPostsWithUser($userID){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE userID = :userID
		", array('userID'=>$userID))->fetchAll();
		return $result;
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
			DisplayTags(GetAllTags($post['postID']));
		}
		if(HasEditPermission($post['postID'])){
			ShowEditButton($post['postID']);
		}
		if(HasDeletePermission($post['postID'])){
			ShowDeleteButton($post['postID']);
		}
		if(ValidComment()){
			ShowAddCommentForm($post['postID']);
		}
		DisplayComments($post['postID']);
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
			DisplayTags(GetAllTags($pic['postID']));
		}
		if(HasEditPermission($pic['postID'])){
			ShowEditButton($pic['postID']);
			// var_dump($pic['postID']);
		}
		if(HasDeletePermission($pic['postID'])){
			ShowDeleteButton($pic['postID']);
		}
		if(ValidComment()){
			ShowAddCommentForm($pic['postID']);
		}
		DisplayComments($pic['postID']);
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
