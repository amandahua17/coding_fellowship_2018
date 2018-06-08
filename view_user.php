<?php
	include('include/include_all.php');
	// var_dump(GetUser($_REQUEST['userID'])['username']);
	$username = GetUserWithID($_REQUEST['userID'])['username'];
	if(isset($_SESSION['nickname'])){
		Heading("View User","View ".$_SESSION['nickname']."'s posts");
	}else{
		Heading("View User","View ".$username."'s posts");
	}

	if($_REQUEST['userID']=='0'){
		foreach(GetAllBlogPosts() as $post){
				DisplayPost($post);
		}
	}else{
		//InsertBlogPost('Amanda Hua', '2018-05-25', 'TestPost', 'Hi this is a test post');
		$posts = GetPostsWithUser($_REQUEST['userID']);
		//var_Dump($post);
		if(!sizeof($posts)){
			echo"$username has no posts!";
		}
		foreach($posts as $key=>$post){
			if($post['postType'] == 'pic'){
				DisplayPic($post);
			}else if($post['postType'] == 'blog'){
				DisplayPost($post);
			}
		}
		// ShowDelete($post['postID']);
	}
	Footer();
