<?php
	include('include/include_all.php');

	Heading("View Post", "");
	if($_REQUEST['postID']=='0'){
		foreach(GetAllBlogPosts() as $post){
			DisplayPost($post);
			echo"<br>";
		}
	}else{
		//InsertBlogPost('Amanda Hua', '2018-05-25', 'TestPost', 'Hi this is a test post');
		$post = GetPost($_REQUEST['postID']);
		//var_Dump($post);
		DisplayPost($post);
		// ShowDelete($post['postID']);
	}
	Footer();
