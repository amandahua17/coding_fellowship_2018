<?php
	include('include/include_all.php');

	$postCount=GetTotalPosts();
	// var_dump($postCount);
	// $picCount=GetNumberPics();

	echo"
		<html>
			<head>
				<title>myBlog</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>Welcome to my blog!</h1>
				<div>
					<h2>Blog Posts</h2>
					<div>";
				// var_dump($postCount, $picCount);
			for($i=1, $posti=1;$i<=$postCount;$i++){
				if (GetPostType($i)=='blog'){
					echo"
						<a href='view_post.php?postID=$i'>".GetPost($i)['title']." by ".GetPost($i)['author']."</a><br><br>
					";
					$posti++;
				}
			}

	echo"
					</div>
				<a href='view_post.php?postID=0'>See All</a>
				</div>
				<div>
					<h2>Pictures</h2>
					<div>";
			for($j=1, $picj=1;$j<=$postCount;$j++){
				if (GetPostType($j)=='pic'){
					echo"
						<a href='view_pic.php?postID=$j'>".GetPost($j)['title']." by ".GetPost($j)['author']."</a><br><br>
					";
					$picj++;
				}
			}
	echo"
					</div>
				<a href='view_pic.php?postID=0'>See All</a>
				</div>
				<div>
					<h2>Write your own entry</h2>
					<a href='create_post.php?type=1'>Picture</a><br><br>
					<a href='create_post.php?type=2'>Blog Post</a>
				</div>
			</body>
		</html>
	";
