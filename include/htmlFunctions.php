<?php
	//HTML FUNCTIONS
	function head($title){
		echo"
			<html>
				<head>
					<title>$title</title>
					<link rel='stylesheet' href='/style/style.css'>
				</head>
				<body>
					<h1>YOLO \t\t JAR</h1>
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

	function foot(){
		echo"
					<script src='/js/jquery.js'></script>
					<script src='/js/jsfunctions.js'></script>
				</body>
			</html>
		";
	}
