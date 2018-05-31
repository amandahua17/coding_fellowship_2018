<?php
	include('include/include_all.php');
	echo"
		<html>
			<head>
				<title>Delete Key Info</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>What is a Delete Key?</h1>
				<p>A delete key is like a password. We don't want a mixup where someone deletes another person's post accidentally, so we prompt a delete<br>key when
				a post is first created, and again if someone tries to delete the post. We recommend that you write your post's delete key down<br>somewhere where you
				can access it so that it is accessible if you want to eventually delete your post.</p>";
	home();
	echo"
			</body>
		</html>
	";
