<?php
	include('include/include_all.php');

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

	echo"
		<html>
			<head>
				<title>Create Your Own Post</title>
				<link rel='stylesheet' href='/style/mainstyle.css'>
			</head>
			<body>";
	if(IsLoggedIn()){
		PersonalHeading();
	}else{

		echo"note: if you are not logged in, anyone can edit or delete your post. To make it so that only you or an administrator can edit or delete your post, log in or create an account.<br>";
		ShowLoginPage();
		ShowCreateAccountPage();
	}
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
					ShowTextField(true, 'Photographer');
					ShowTextField(true, 'Title');
					ShowTextField(false, 'Body');
					ShowTextField(true, 'Link');
					ShowTextField(false, 'Flavortext');
					echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";


				}else if($type=='blog'){
					ShowTextField(false, 'Author');
					ShowTextField(true, 'Title');
					ShowTextField(true, 'Body');
				}
				ShowTagField();
				ShowHiddenField('tagString', @$_REQUEST['tagString']);
				// var_dump(@$_REQUEST['tagString']);


	echo"
					<input type='submit' name = 'button'>
				</form>";

	Home();
	echo	"</body>
		</html>
	";
