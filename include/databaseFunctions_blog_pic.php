
<?php

	function home(){
		echo"<a href='index.php'>back to home</a>";
	}

	function showDelete($postID){
		$post = GetPost($postID);
		echo"
			<button onClick='scriptDelete($post[delKey])'>Delete Post</button><br><br>
		";
		echo"
			<script>
				function scriptDelete(delKey){
					var key = prompt('Please enter delete key.', '');
					if(key == delKey){
						document.write(key);
						document.write(delKey);
					}
				}
			</script>
		";

		// if(isset($_REQUEST['delete'])){
		// 	var_dump(GetPost($postID)['delKey']);
		// 	echo"
		// 		<script>
		// 			alert('fdhldh');
		// 			var key = prompt('Please enter delete key.');
		// 			if(key == ".GetPost($postID)['delKey']."){
		// 				".DeletePost($postID)."
		// 			}
		// 			else{
		// 				alert('Wrong Delete Key! You do not have permission to delete this post.<br>');
		// 			}
		// 		</script>
		// 	";
		// }
	}

	function validateTextField($key, $errors){
		if(!$_REQUEST[$key]){
			$errors[$key] = "required";
		}
		return $errors;
	}

	function showTextField($isreq, $name){
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
			INSERT INTO posts (author, title, body, isPic, delKey)
			VALUES('$author', '$title', '$body', '0', '$delKey')
		")->fetch();
	}

	function GetAllBlogPosts(){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE isPic=0
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
				</div>
			</body>
		</html>
		";
	}

	function getNumberPosts(){
		$result = dbQuery("
				SELECT COUNT(postID) AS count
				FROM posts
				WHERE isPic=0
			")->fetch();
		return $result['count'];
	}


	//PIC FUNCTIONS
	function InsertPic($photographer, $title, $body, $link, $flavor, $delKey){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, isPic, link, flavor, delKey)
			VALUES('$photographer', '$title', '$body', '1','$link', '$flavor', '$delKey')
		")->fetch();
	}

	function GetAllPics(){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE isPic=1
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
		echo"<br>
			</body>
		</html>
		";
	}

	function getNumberPics(){
		$result = dbQuery("
				SELECT COUNT(postID) AS count
				FROM posts
				WHERE isPic=1
			")->fetch();
		return $result['count'];
	}

	//BOTH

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
	}

	function isPicture($postID){
		if(GetPost($postID)['isPic']==1){
			return true;
		}
		return false;
	}

	function getTotalPosts(){
		$result = dbQuery("
			SELECT COUNT(postID) AS count
			FROM posts
		")->fetch();
		return $result['count'];
	}
