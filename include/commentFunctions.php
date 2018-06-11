<?php
//COMMENT FUNCTIONS

//COMMENT DATABASE FUNCTIONS
function AddNewComment($comment, $postID){
	$result=dbQuery("
		INSERT INTO comments (postID, userID, body)
		VALUES (:postID, $_SESSION[userID], :comment)
	", array('postID'=>$postID, 'comment'=>$comment))->fetch();
}

function DisplayComments($postID){
	if(isset($_REQUEST['DCommentID'])){
		DeleteComment($_REQUEST['DCommentID']);
	}
	if(isset($_REQUEST['ECommentID'])){
		if(isset($_REQUEST['editcom'.$_REQUEST['ECommentID']])){
			// var_dump($_REQUEST);
			EditComment($_REQUEST['ECommentID'], $_REQUEST['Edit']);
		}else{
			ShowEditComment($_REQUEST['ECommentID']);
		}
	}
	$comments = GetComments($postID);
	$type = GetPostType($postID);
	if($type == 'pic'){
		$url = '/view_pic.php?postID='.$postID;
	}else if ($type == 'blog'){
		$url = '/view_post.php?postID='.$postID;
	}
	if(sizeof($comments)){
		echo"Comments: <br><br>";
	}
	foreach($comments as $comment){
		// var_dump(GetUserWithID($comment['userID'])['username']);
		echo"\t<span style='padding:4px;
		background-color:#eee;'class='comment'>
		<a style='padding:2px;
		font-weight:bold;
		background-color:#ddd;
		color:#fff;'class='userbadge' href='/view_user.php?userID=".$comment['userID']."'>".GetUserWithID($comment['userID'])['username']."</a>
		".$comment['body'];
		if(ValidEditComment($comment['commentID'])){
			echo"\t<a style='color: grey' href='".$url."&DCommentID=".$comment['commentID']."'>delete comment</a>";
			echo"\t<a style='color: grey' href='".$url."&ECommentID=".$comment['commentID']."'>edit comment</a>";
			//PLACE EDIT COMMENT HERE
		}
		echo"</span><br><br>";
	}
	echo"<br><br>";
}

function ShowEditComment($commentID){
	echo"
		<form method='post'>";
		ShowTextField(false, 'Edit Comment', GetComment($commentID)['body']);
	echo"
			<input type='submit' name='editcom".$commentID."'>
		</form>
	";
}

function GetComments($postID){
	$result=dbQuery("
		SELECT *
		FROM comments
		WHERE postID = :postID
	", array('postID'=>$postID))->fetchAll();
	// var_dump($result);
	return $result;
}

function GetComment($commentID){
	$result=dbQuery("
		SELECT *
		FROM comments
		WHERE commentID = :commentID
	", array('commentID'=>$commentID))->fetch();
	// var_dump($result);
	return $result;
}

function DeleteComment($commentID){
	$result=dbQuery("
		DELETE FROM comments
		WHERE commentID = :commentID
	", array('commentID'=>$commentID))->fetch();
}

function EditComment($commentID, $body){
	$result = dbQuery("
		UPDATE comments
		SET body = :body
		WHERE commentID = :commentID
	", array('body'=>$body, 'commentID'=>$commentID))->fetch();
}
