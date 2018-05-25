<?php
	include('config/config.php');
	include('include/db_query.php');

	//InsertBlogPost('Amanda Hua', '2018-05-25', 'TestPost', 'Hi this is a test post');
	$post = GetBlogPost($_REQUEST['postID']);
	//var_Dump($post);
	DisplayPost($post);


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
			")->fetch();
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
					<a href='index.html'>back to home</a>
				</body>
			</html>
			";
		}
