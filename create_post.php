<?php
	include('include/include_all.php');

	$type=$_REQUEST['type'];		//type 1 is picture, type 2 is post
	$errors = array();

	if(isset($_REQUEST['button'])&&($type == 2)){
		$errors+=ValidateTextField('Title', $errors);
		$errors+=ValidateTextField('Body', $errors);
		if(sizeof($errors)==0){
			InsertBlogPost($_REQUEST['Author'], $_REQUEST['Title'], $_REQUEST['Body']);
			header('Location: index.php');
			exit();
		}
	}

	if(isset($_REQUEST['button'])&&($type == 1)){
		$errors+=ValidateTextField('Photographer', $errors);
		$errors+=ValidateTextField('Title', $errors);
		$errors+=ValidateTextField('Link', $errors);
		// var_dump($errors);
		if(sizeof($errors) == 0){
			InsertPic($_REQUEST['Photographer'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['Link'], $_REQUEST['Flavortext']);
			header('Location: index.php');
			exit();
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
	}else{
		echo"note: if you are not logged in, anyone can edit or delete your post. To make it so that only you or an administrator can edit or delete your post, log in or create an account.<br>";
		ShowLoginPage();
		ShowCreateAccountPage();
	}
	echo"
				<h1>Create Your Own";
	if($type == 1){		//HERE
		echo" Picture ";
	}else{		//HERE
		echo" Blog ";
	}
	echo							"Post</h1>";

	foreach($errors as $key=>$val){
		echo"<span style='color: red'>$key is a required field!<br></span>";
	}

	echo"
				<br><form method='post'>";
				if($type== 1){
					ShowTextField(true, 'Photographer');
					ShowTextField(true, 'Title');
					ShowTextField(false, 'Body');
					ShowTextField(true, 'Link');
					ShowTextField(false, 'Flavortext');
					echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";
					// echo"<p class='required'>Photographer*:</p><input type='text' name='photographer' value='$_REQUEST[photographer]'><br><br>
					// 	 <p class='required'>Title*:</p><input type='text' name='title' value='$_REQUEST[title]'><br><br>
					// 	 Post Body (optional):<br><textarea name='body' rows='5' cols='40' value='$_REQUEST[body]'></textarea><br><br>
					// 	 <p class='required'>Photo Path*:</p><input type='text' name='link' value='$_REQUEST[link]'><br><br>
					// 	 Flavortext:<br><input type='text' name='flavor' value='$_REQUEST[flavor]'><br><br>
					// 	 <a href='flavorInfo.php'>What is flavor text?</a><br>
					// 	 <p class='required'>Delete Key*:</p><input type='password' name='delKey' value='$_REQUEST[delKey]'><br><br>
					// 	 <a href='delKeyInfo.php'>What is a Delete Key?</a><br><br>";
				}else if($type==2){		//HERE
					ShowTextField(false, 'Author');
					ShowTextField(true, 'Title');
					ShowTextField(true, 'Body');
					// echo"Author:<br><input type='text' name='author'><br><br>
					// 	 <p class='required'>Title*:</p><input type='text' name='title' value='$_REQUEST[title]'><br><br>
					// 	 <p class='required'>Post Body*:</p><textarea name='body' rows='5' cols='40' value='$_REQUEST[body]'></textarea><br><br>
					// 	 <p class='required'>Delete Key*:</p><input type='password' name='delKey' value='$_REQUEST[delKey]'><br><br>
					// 	 <a href='delKeyInfo.php'>What is a Delete Key?</a><br><br>";
				}

	echo"
					<input type='submit' name = 'button'>
				</form>";
		// if($type == 1){
		// 	if(isset($_REQUEST['photographer'])&&isset($_REQUEST['title'])&&isset($_REQUEST['link'])){
		// 		if(!isset($_REQUEST['flavor'])){
		// 				$_REQUEST['flavor'] = $_REQUEST['photographer'];
		// 		}
		// 		InsertPic($_REQUEST['photographer'], $_REQUEST['title'], $_REQUEST['body'], $_REQUEST['link'], $_REQUEST['flavor'], $_REQUEST['delKey']);
		// 		echo"Picture added!<br>";
		// 	}else if (isset($_REQUEST['photographer'])||isset($_REQUEST['title'])||isset($_REQUEST['link'])){
		// 		echo"Picture not added, please fill all the required fields!<br>";
		// 	}
		// }else{
		// 	if(isset($_REQUEST['title'])&&isset($_REQUEST['body'])){
		// 		if(!isset($_REQUEST['author'])){
		// 			$_REQUEST['author'] = 'Anonymous';
		// 		}
		// 		InsertBlogPost($_REQUEST['author'], $_REQUEST['title'], $_REQUEST['body'], $_REQUEST['delKey']);
		// 		echo"Post added!<br>";
		// 	}else if(isset($_REQUEST['title'])||isset($_REQUEST['body'])){
		// 		echo"Post not added, please fill all the required fields!<br>";
		// 	}
		// }
		Home();
	echo	"</body>
		</html>
	";
