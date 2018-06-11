<?php
//POST FUNCTIONS

//BLOG DATABASE FUNCTIONS
function InsertBlogPost($author, $title, $body, $tagarray){
	if(!$author){
		$author = 'Anonymous';
	}
	if(!$_SESSION['userID']){
		$_SESSION['userID'] = NULL;
	}
	// var_dump($author, $title, $body, $_SESSION);
	dbQuery("
		INSERT INTO posts (author, title, body, postType, userID)
		VALUES(:author, :title, :body, 'blog', '$_SESSION[userID]')
	", array('author'=>$author, 'title'=>addslashes($title), 'body'=>addslashes($body)))->fetch();
	$result = GetLastPostID();
	// var_dump($result);
	// die("Blog Post should be inserted by now");
	AttachTags($result['postID'], $tagarray);
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
			<link rel='stylesheet' href='/style/mainstyle.css'>
		</head>
		<body>
			<h1>".$post['title']."</h1>
			<h2>by ".$post['author']."</h2>
			<h3>date: ".$post['date']."</h3>
			<div>
				<p>".$post['body']."</p><br>
			</div>";
	if(HasTags($post['postID'])){
		DisplayTags(GetAllTags($post['postID']));
	}
	if(HasEditPermission($post['postID'])){
		ShowEditButton($post['postID']);
	}
	if(HasDeletePermission($post['postID'])){
		ShowDeleteButton($post['postID']);
	}
	if(ValidComment()){
		ShowAddCommentForm($post['postID']);
	}
	DisplayComments($post['postID']);
	echo		"
		</body>
	</html>
	";
}

//PIC DATABASE FUNCTIONS
function InsertPic($photographer, $title, $body, $link, $flavor, $tagarray){
	if(!$_SESSION['userID']){
		$_SESSION['userID'] = NULL;
	}
	dbQuery("
	INSERT INTO posts (author, title, body, postType, link, flavor, userID)
	VALUES(:photographer, :title, :body, 'pic',:link, :flavor, '$_SESSION[userID]')
	", array('photographer'=>$photographer, 'title'=>$title, 'body'=>$body, 'link'=>$link, 'flavor'=>$flavor))->fetch();
	$result = GetLastPostID();
	AttachTags($result['postID'], $tagarray);
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
			<link rel='stylesheet' href='/style/mainstyle.css'>
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
	if(HasTags($pic['postID'])){
		DisplayTags(GetAllTags($pic['postID']));
	}
	if(HasEditPermission($pic['postID'])){
		ShowEditButton($pic['postID']);
		// var_dump($pic['postID']);
	}
	if(HasDeletePermission($pic['postID'])){
		ShowDeleteButton($pic['postID']);
	}
	if(ValidComment()){
		ShowAddCommentForm($pic['postID']);
	}
	DisplayComments($pic['postID']);
	echo"
		</body>
	</html>
	";
}

//GENERIC POST DATABASE FUNCTIONS
function GetLastPostID(){
	$result = dbQuery("
		SELECT LAST_INSERT_ID() as postID;
	")->fetch();
	return $result;
}

function GetPost($postID){
	$result = dbQuery("
		SELECT *
		FROM posts
		WHERE postID = :postID
	", array('postID'=>$postID))->fetch();
	return $result;
}

function DeletePost($postID){
	$result = dbQuery("
		DELETE FROM posts
		WHERE postID = :postID
	", array('postID'=>$postID))->fetch();
	$result = dbQuery("
		DELETE FROM posttags
		WHERE postID = :postID
	", array('postID'=>$postID))->fetch();
	echo"Post Deleted.<br>";
	// ResetAuto(GetTotalPosts());
}

function GetPostType($postID){
	return GetPost($postID)['postType'];
}

function GetRecentPost(){
	$result = dbQuery("
		SELECT *, MAX(postID)
		AS recentpost
		FROM posts
	")->fetch();
	// var_dump($result);
	return $result['recentpost'];
}

function EditPost($postID, $changes, $tagarray){
	// var_dump($changes);
	// die();
	$type = GetPost($postID)['postType'];
	// echo"EditPost Called!";
	// var_dump($changes);
	// foreach($changes as $column=>$change){
		// var_dump($column, $change);
		// var_dump($changes, $type);
		// die();
	if($type == 'pic'){
		dbQuery("
			UPDATE posts
			SET author = :phot, title = :title, body = :body, link = :link, flavor = :flavor
			WHERE postID = :postID
		", array('phot'=>$changes['Author'],
				'title'=>$changes['Title'],
				'body'=>$changes['Body'],
				'link'=>$changes['Link'],
				'flavor'=>$changes['Flavor'],
				'postID'=>$postID))->fetchAll();
	}else if ($type == 'blog'){

		dbQuery("
			UPDATE posts
			SET author = :author, title = :title, body = :body
			WHERE postID = :postID
		", array('author'=>$changes['Author'],
				'title'=>$changes['Title'],
				'body'=>$changes['Body'],
				'postID'=>$postID))->fetchAll();
	}
	// }
	AttachTags($postID, $tagarray);
}

function GetPostAttributeArray($postID){
	$result = array();
	$type = GetPost($postID)['postType'];
	$placeholder = dbQuery("
		SELECT *
		FROM typeattributes
		INNER JOIN posttypes ON typeattributes.typeID = posttypes.typeID
		WHERE posttypes.postType = :type
	", array('type'=>$type))->fetch();
	foreach($placeholder as $key=>$val){
		if($val != NULL){
			if(($key != 'typeID')&&($key != 'postType'))
			$result[$key] = $placeholder[$key];
		}
	}
	// var_dump($result);
	return $result;
}
