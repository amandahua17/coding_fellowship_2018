<?php
	include('config/config.php');
	include('include/db_query.php');
	//POST FUNCTIONS
	function InsertBlogPost($author, $title, $body){
		$result = dbQuery("
			INSERT INTO posts (author, title, body, isPic)
			VALUES('$author', '$title', '$body', '0')
		")->fetch();
	}

	function GetAllBlogPosts($postID){
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
					<p>".$post['body']."</p>
				</div>
				<a href='index.php'>back to home</a>
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
	function InsertPic($photographer, $title, $link, $flavor){
		$result = dbQuery("
			INSERT INTO posts (author, title, isPic, link, flavor)
			VALUES('$photographer', '$title', '1','$link', '$flavor')
		")->fetch();
	}

	function GetAllPics($picID){
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
				</div>
				<a href='index.php'>back to home</a>
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
