<?php
	include('include/include_all.php');

	$type=$_REQUEST['type'];
	$errors = array();

	if(isset($_REQUEST['button'])&&($type == 2)){
		$errors+=validateTextField('Title', $errors);
		$errors+=validateTextField('Body', $errors);
		$errors+=validateTextField('DeleteKey', $errors);
		if(!$_REQUEST['Author']){
			$_REQUEST['Author'] = 'Anonymous';
		}
		if(sizeof($errors)==0){
			insertBlogPost($_REQUEST['Author'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['DeleteKey']);
			header('Location: success.php');
		}
	}

	if(isset($_REQUEST['button'])&&($type == 1)){
		$errors+=validateTextField('Photographer', $errors);
		$errors+=validateTextField('Title', $errors);
		$errors+=validateTextField('Link', $errors);
		$errors+=validateTextField('DeleteKey', $errors);
		// var_dump($errors);
		if(sizeof($errors) == 0){
			insertPic($_REQUEST['Photographer'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['Link'], $_REQUEST['Flavortext'], $_REQUEST['DeleteKey']);
			header('Location: success.php');
		}
	}

	echo"
		<html>
			<head>
				<title>Create Your Own Post</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>Create Your Own";
	if($type == 1){
		echo" Picture ";
	}else{
		echo" Blog ";
	}
	echo							"Post</h1>";

	foreach($errors as $key=>$val){
		echo"<span style='color: red'>$key is a required field!<br></span>";
	}

	echo"
				<br><form method='post'>";
				if($type== 1){
					showTextField(true, 'Photographer');
					showTextField(true, 'Title');
					showTextField(false, 'Body');
					showTextField(true, 'Link');
					showTextField(false, 'Flavortext');
					echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";
					showTextField(true, 'DeleteKey');
					echo"<a href='delKeyInfo.php'>What is a Delete Key?</a><br><br>";
					// echo"<p class='required'>Photographer*:</p><input type='text' name='photographer' value='$_REQUEST[photographer]'><br><br>
					// 	 <p class='required'>Title*:</p><input type='text' name='title' value='$_REQUEST[title]'><br><br>
					// 	 Post Body (optional):<br><textarea name='body' rows='5' cols='40' value='$_REQUEST[body]'></textarea><br><br>
					// 	 <p class='required'>Photo Path*:</p><input type='text' name='link' value='$_REQUEST[link]'><br><br>
					// 	 Flavortext:<br><input type='text' name='flavor' value='$_REQUEST[flavor]'><br><br>
					// 	 <a href='flavorInfo.php'>What is flavor text?</a><br>
					// 	 <p class='required'>Delete Key*:</p><input type='password' name='delKey' value='$_REQUEST[delKey]'><br><br>
					// 	 <a href='delKeyInfo.php'>What is a Delete Key?</a><br><br>";
				}else{
					showTextField(false, 'Author');
					showTextField(true, 'Title');
					showTextField(true, 'Body');
					showTextField(true, 'DeleteKey');
					echo"<a href='delKeyInfo.php'>What is a Delete Key?</a><br><br>";
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
		// 		insertPic($_REQUEST['photographer'], $_REQUEST['title'], $_REQUEST['body'], $_REQUEST['link'], $_REQUEST['flavor'], $_REQUEST['delKey']);
		// 		echo"Picture added!<br>";
		// 	}else if (isset($_REQUEST['photographer'])||isset($_REQUEST['title'])||isset($_REQUEST['link'])){
		// 		echo"Picture not added, please fill all the required fields!<br>";
		// 	}
		// }else{
		// 	if(isset($_REQUEST['title'])&&isset($_REQUEST['body'])){
		// 		if(!isset($_REQUEST['author'])){
		// 			$_REQUEST['author'] = 'Anonymous';
		// 		}
		// 		insertBlogPost($_REQUEST['author'], $_REQUEST['title'], $_REQUEST['body'], $_REQUEST['delKey']);
		// 		echo"Post added!<br>";
		// 	}else if(isset($_REQUEST['title'])||isset($_REQUEST['body'])){
		// 		echo"Post not added, please fill all the required fields!<br>";
		// 	}
		// }
		home();
	echo	"</body>
		</html>
	";
