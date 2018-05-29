
<?php
	include('config/config.php');
	include('include/db_query.php');

	function home(){
		echo"<a href='index.php'>back to home</a>";
	}

	function showDelete($postID){
		echo"
			<button onClick='scriptDelete($_REQUEST[delKey])'>Delete Post</button><br><br>
		";
		echo"
			<script>
				function scriptDelete(delKey){
					var key = prompt('Please enter delete key.');
					if(key == delKey){
						".DeletePost($postID)."
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
				SELECT COUNT(postID)
				FROM posts
				WHERE isPic=0
			")->fetch();
		return $result['COUNT(postID)'];
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
				SELECT COUNT(postID)
				FROM posts
				WHERE isPic=1
			")->fetch();
		return $result['COUNT(postID)'];
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

	function isPicture($post){
		$result = dbQuery("
				SELECT isPic
				FROM posts
				WHERE postID=$post[postID]
			")->fetch();
		if($result['isPic']==1){
			return true;
		}
		return false;
	}

	function getTotalPosts(){
		$result = dbQuery("
			SELECT COUNT(postID)
			FROM posts
		")->fetch();
		return $result['COUNT(postID)'];
	}
