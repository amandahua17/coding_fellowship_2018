<?php
	include('include/include_all.php');

	Heading("View Tag","");
	if($_REQUEST['tagID']=='0'){
		foreach(GetAllBlogPosts() as $post){
			if(HasTags($post)){
				DisplayPost($post);
			}
		}
	}else{
		//InsertBlogPost('Amanda Hua', '2018-05-25', 'TestPost', 'Hi this is a test post');
		$posts = GetPostsWithTag($_REQUEST['tagID']);
		//var_Dump($post);
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
