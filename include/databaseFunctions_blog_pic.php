
<?php

	function Home(){
		echo"<a href='index.php'>back to home</a>";
	}

	function ShowDelete($postID){
		$delKey = GetPost($postID)['delKey'];
		var_dump($delKey);
		echo"
			<button onClick='scriptDelete()'>Delete Post</button><br><br>
		";
		echo"
			<script>
				var delKey = '".$delKey."';

				alert(delKey);
				function scriptDelete(){
					var key = prompt('Please enter delete key.', '');
					if(key == delKey){
						document.write('Deleted.');
					}else{
						document.write('key:', key);
						document.write('delKey:', delKey);
						alert('Incorrect Key!')
					}
				}
			</script>
		";

	}

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

	//POST FUNCTIONS
	function InsertBlogPost($author, $title, $body, $delKey){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, delKey)
			VALUES('$author', '$title', '$body', 'blog', '$delKey')
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
		ShowDelete($post['postID']);
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


	//PIC FUNCTIONS
	function InsertPic($photographer, $title, $body, $link, $flavor, $delKey){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, postType, link, flavor, delKey)
			VALUES('$photographer', '$title', '$body', 'pic','$link', '$flavor', '$delKey')
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
		ShowDelete($pic['postID']);
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

	//ALL

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
			SELECT COUNT(postID) AS count
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
