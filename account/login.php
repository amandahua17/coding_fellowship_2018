<?php
	include('/include/include_all.php');
	if(IsLoggedIn()){
		header("Location: /index.php");
	}
	Heading("Login", "Login");
	LoginForm();
	echo"
			</body>
		</html>
	";
Home();
