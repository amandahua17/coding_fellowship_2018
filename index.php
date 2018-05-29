<?php
	// include('post_database.php');
	// include('pic_database.php');
		include('include/databaseFunctions.php');

	$postCount=getTotalPosts();
	// $picCount=getNumberPics();

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
			for($i=1;$i<=$postCount;$i++){
				if (!isPicture(GetPost($i))){
					echo"
						<a href='view_post.php?postID=$i'>Post $i</a>
					";
				// var_dump($i, $postCount, ($i<=$postCount));
				}
			}

	echo"
					</div>
				</div>
				<div>
					<h2>Pictures</h2>
					<div>";
			for($j=1, $picj=1;$j<=$postCount;$j++){
				// var_dump(isPicture(GetPost($j)));
				if (isPicture(GetPost($j))){
					echo"
						<a href='view_pic.php?postID=$j'>Picture $picj</a>
					";
					$picj++;
				}
			}
	echo"
					</div>
				</div>
				<div>
					<h2>Write your own entry</h2>
					<a href='create_post.php?type=1,picCount=".getNumberPics()."'>Picture</a><br><br>
					<a href='create_post.php?type=2,postCount=".getNumberPosts()."'>Blog Post</a>
				</div>
			</body>
		</html>
	";
