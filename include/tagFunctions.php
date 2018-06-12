<?php
//TAG FUNCTIONS

//TAG DATABASE FUNCTIONS
function DeleteTagFromPost($tagID, $postID){
	$result = dbQuery("
		DELETE FROM posttags
		WHERE tagID = :tagID
		AND postID = :postID
	", array('tagID'=>$tagID, 'postID'=>$postID))->fetch();
}

function DeleteTagOverall($name){
	$result = dbQuery("
		DELETE FROM tags
		WHERE tagname = :name
	", array('name'=>$name))->fetch();
}

function NewTag($name){
	dbQuery("
		INSERT INTO tags (tagname)
		VALUES(:name)
	", array('name'=>$name))->fetch();
}

function AttachTags($postID, $tagarray){
	// echo"attachtags called, postID: ";
	// var_dump($postID);
	for($i=0;$i<sizeof($tagarray);$i++){
		// die("forloop");
		if(($tagarray[$i] == 'null')||($tagarray[$i] == '')){
			continue;
		}
		if(!TagExists($tagarray[$i])){
			// echo"<br>CREATING A NEW TAG<br>";
			NewTag($tagarray[$i]);
		}
		$tagID=GetTag($tagarray[$i])['tagID'];
		// if(!TagDuplicate($postID, $tagID)){
		dbQuery("
			REPLACE INTO posttags (postID, tagID)
			VALUES(:postID, :tagID)
		", array('postID'=>$postID, 'tagID'=>$tagID))->fetchAll();
		// }
	}
	 // die();
}

function GetTag($name){
	$result=dbQuery("
		SELECT *
		FROM tags
		WHERE tagname = :name
	", array('name'=>$name))->fetch();
	return $result;
}

function GetAllTags($postID){
	$result=dbQuery("
		SELECT tagname
		FROM tags
		INNER JOIN posttags ON tags.tagID = posttags.tagID
		WHERE posttags.postID = :postID
	", array('postID'=>$postID))->fetchAll();
	// var_dump($result);
	return $result;
}

function HasTags($postID){
	// echo"HasTags called";
	$result = dbQuery("
		SELECT *
		FROM posttags
		WHERE postID = :postID
	", array('postID'=>$postID))->fetchAll();
	// var_dump($result);
	if(!$result){
		return false;
	}
	return true;
}

function TagExists($name){
	echo"tagexists called";
	$result = dbQuery("
		SELECT *
		FROM tags
		WHERE tagname = :name
	", array('name'=>$name))->fetchAll();
	if(!$result){
		return false;
	}
	return true;
}

function GetPostsWithTag($tagID){
	$result = dbQuery("
		SELECT *
		FROM posts
		INNER JOIN posttags
		ON posts.postID = posttags.postID
		WHERE posttags.tagID = :tagID
	", array('tagID'=>$tagID))->fetchAll();
	return $result;
}

//OTHER TAG FUNCTIONS
function DisplayTags($tagarray){

	echo"<p>Tags: </p>";
	foreach($tagarray as $tag){
		$tagID = GetTag($tag['tagname'])['tagID'];
		echo"<span id='tag'><a class='tag' href='/view_tag.php?tagID=".$tagID."'>#".$tag['tagname']."</a></span>
		\t";
	}
}
