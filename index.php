<?php
	// include('post_database.php');
	// include('pic_database.php');
		include('include/databaseFunctions.php');

	$postCount=getNumberPosts()['COUNT(postID)'];
	$picCount=getNumberPics()['COUNT(picID)'];
	echo"
		<html>
			<head>
				<title>myBlog</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>Welcome to my blog!</h1>
				<div>
					<h2>Posts</h2>
					<div>";
				// var_dump($postCount, $picCount);
			for($i=1;$i<=$postCount;$i++){
				echo"
					<a href='view_post.php?postID=$i'>Post $i</a>
				";
				// var_dump($i, $postCount, ($i<=$postCount));
			}

	echo"
					</div>
				</div>
				<div>
					<h2>Pictures</h2>
					<div>";
			for($j=1;$j<=$picCount;$j++){
				echo"
					<a href='view_pic.php?picID=$j'>Picture $j</a>
				";
			}
	echo"
					</div>
				</div>
			</body>
		</html>
	";
