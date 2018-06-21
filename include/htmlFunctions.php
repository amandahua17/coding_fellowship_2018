<?php
	//HTML FUNCTIONS
	function head($title){
		echo"
			<html>
				<head>
					<title>$title</title>
					<link rel='stylesheet' href='/style/style".getTheme().".css'>
				</head>
				<body>
					<h1>YOLO \t\t JAR</h1>
		";
		// var_dump(getTheme());
	}

	function timelineHead($title){
		echo"
			<html>
				<head>
					<title>$title</title>
					<link rel='stylesheet' href='/style/timelineStyle.css'>
				</head>
				<body>
					<h1>YOLO \t\t JAR</h1>
		";
	}

	function userTimelineLink(){
		echo"
			<a href='/sitefiles/user_timeline.php?userid=".$_SESSION['userid']."'>Your Timeline</a>
		";
	}
	function logoutButton(){
		echo"
			<form method='post'>
				<input type='submit' class='logout' name='logout' value='logout'>
			</form>
		";
	}

	function loginButton(){
		echo"
			<button class='login' onclick='showLoginForm()'>login</button>
		";
	}

	function createAccountButton(){
		echo"
			<button class='createaccount' onclick='showCreateAccountForm()'>create account</button>
		";
	}

	function addEntryButton(){
		echo"
			<button class='addEntryButton' onclick='showAddEntryForm()'>new entry</button>
		";
	}

	function foot(){
		// echo"FOOT";
		if($_SERVER['PHP_SELF']!= '/index.php'){
			echo"
					<br><a class='home' href='/index.php'>Home</a>
			";
		}
		echo 		"<script src='js/jquery.js'></script>
					<script src='js/jsfunctions.js'></script>
				</body>
			</html>
		";
	}
