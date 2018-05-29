<?php
	include('config/config.php');
	include('include/db_query.php');
	//POST FUNCTIONS
	function InsertBlogPost($author, $date, $title, $body){
		$result = dbQuery("
			INSERT INTO posts (author, date, title, body)
			VALUES('$author', '$date', '$title', '$body')
		")->fetch();
	}

	function GetBlogPost($postID){
		$result = dbQuery("
			SELECT *
			FROM posts
			WHERE postID = $postID
		")->fetch();
		return $result;
	}

	function DeleteBlogPost($postID){
		$result = dbQuery("
			DELETE FROM posts
			WHERE postID = $postID
		")->fetch();
	}

	function GetAllBlogPosts($postID){
		$result = dbQuery("
			SELECT *
			FROM posts
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
			")->fetch();
		return $result;
	}


	//PIC FUNCTIONS
	function InsertPic($photographer, $date, $title, $link, $flavor){
		$result = dbQuery("
			INSERT INTO pics (photographer, date, title, link, flavor)
			VALUES('$photographer', '$date', '$title', '$link', '$flavor')
		")->fetch();
	}

	function GetPic($picID){
		$result = dbQuery("
			SELECT *
			FROM pics
			WHERE picID = $picID
		")->fetch();
		return $result;
	}

	function DeletePic($picID){
		$result = dbQuery("
			DELETE FROM pics
			WHERE postID = $picID
		")->fetch();
	}

	function GetAllPics($picID){
		$result = dbQuery("
			SELECT *
			FROM pics
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
				<h2>by ".$pic['photographer']."</h2>
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
				SELECT COUNT(picID)
				FROM pics
			")->fetch();
		return $result;
	}
