<?php
	include('include/include_all.php');

	if($_REQUEST['postID']=='0'){
		foreach(GetAllBlogPosts() as $post){
			DisplayPost($post);
		}
	}else{
		//InsertBlogPost('Amanda Hua', '2018-05-25', 'TestPost', 'Hi this is a test post');
		$post = GetPost($_REQUEST['postID']);
		//var_Dump($post);
		DisplayPost($post);
		ShowDelete($post['postID']);
	}
	Home();
