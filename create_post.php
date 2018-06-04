<?php
	include('include/include_all.php');

	$type=$_REQUEST['type'];		//type 1 is picture, type 2 is post
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

	if(isset($_REQUEST['button'])&&($type == 2)){
		$errors+=ValidateTextField('Title', $errors);
		$errors+=ValidateTextField('Body', $errors);
		if(!$_REQUEST['Author']){
			$_REQUEST['Author'] = 'Anonymous';
		}
		if(sizeof($errors)==0){
			// var_dump($tagarray);
			InsertBlogPost($_REQUEST['Author'], $_REQUEST['Title'], $_REQUEST['Body'], $tagarray);
			header('Location: index.php');
		}
	}

	if(isset($_REQUEST['button'])&&($type == 1)){
		$errors+=ValidateTextField('Photographer', $errors);
		$errors+=ValidateTextField('Title', $errors);
		$errors+=ValidateTextField('Link', $errors);
		if(sizeof($errors) == 0){
			// var_dump($tagarray);
			InsertPic($_REQUEST['Photographer'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['Link'], $_REQUEST['Flavortext'], $tagarray);
			header('Location: index.php');
		}
	}

	echo"
		<html>
			<head>
				<title>Create Your Own Post</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>";
	if(IsLoggedIn()){
		PersonalHeading();
		echo"
					<h1>Create Your Own";
		if($type == 1){
			echo" Picture ";
		}else if ($type == 2){
			echo" Blog ";
		}
		echo							"Post</h1>";

		foreach($errors as $key=>$val){
			echo"<span style='color: red'>$key is a required field!<br></span>";
		}

		echo"
					<br><form method='post' name='form'>";
					if($type== 1){
						ShowTextField(true, 'Photographer');
						ShowTextField(true, 'Title');
						ShowTextField(false, 'Body');
						ShowTextField(true, 'Link');
						ShowTextField(false, 'Flavortext');
						echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";


					}else if($type==2){
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

	}else{
		echo"Please log in to create a post!";
	}
	Home();
	echo	"</body>
		</html>
	";
