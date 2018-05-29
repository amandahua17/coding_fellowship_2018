<?php
	include('include/databaseFunctions.php');

	//InsertBlogPost('Amanda Hua', '2018-05-25', 'TestPost', 'Hi this is a test post');
	$post = GetBlogPost($_REQUEST['postID']);
	//var_Dump($post);
	DisplayPost($post);


	
