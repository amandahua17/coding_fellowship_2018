<?php
	include('include/include_all.php');

	$postCount=GetTotalPosts();
	// var_dump($postCount);
	// $picCount=GetNumberPics();
	// ResetAuto(GetTotalPosts());
	echo"
		<html>
			<head>
				<title>myBlog</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>";
	if(IsLoggedIn()){
		PersonalHeading();
	}
	echo"
				<h1>Welcome to my blog!</h1>";
	ShowLoginPage();
	ShowCreateAccountPage();
	echo"
				<div>
					<h2>Blog Posts</h2>
					<div>";
				// var_dump($postCount, $picCount);
			// for($i=1, $posti=1;$i<=$postCount;$i++){
			$blogposts = GetAllBlogPosts();
			foreach($blogposts as $post){
				// if (GetPostType($post['postID'])=='blog'){
					echo"
						<a href='view_post.php?postID=".$post['postID']."'>".$post['title']." by ".$post['author']."</a><br><br>
					";
				// }
			}
	echo"
					</div>
				<a href='view_post.php?postID=0'>See All</a>
				</div>
				<div>
					<h2>Pictures</h2>
					<div>";
				$picposts = GetAllPics();
			foreach($picposts as $post){
				// if (GetPostType($j)=='pic'){
					echo"
						<a href='view_pic.php?postID=".$post['postID']."'>".$post['title']." by ".$post['author']."</a><br><br>
					";
				// }
			}
	echo"
					</div>
				<a href='view_pic.php?postID=0'>See All</a>
				</div>
				<div>
					<h2>Write your own entry</h2>
					<a href='create_post.php?type=pic'>Picture</a><br><br>
					<a href='create_post.php?type=blog'>Blog Post</a>
				</div>
			</body>
		</html>
	";
