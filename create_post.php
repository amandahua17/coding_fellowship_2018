<?php
	include('include/databaseFunctions.php');

	$type=$_REQUEST['type'];
	echo"
		<html>
			<head>
				<title>Create Your Own Post</title>
				<link rel='stylesheet' href='style.css'>
			</head>
			<body>
				<h1>Create Your Own";
				if($type == 1){
					echo" Picture ";
				}else{
					echo" Blog ";
				}

	echo							"Post</h1>
				<form method='post'>";
				if($type== 1){
					echo"<p class='required'>Photographer*:</p><input type='text' name='photographer'><br><br>
						 <p class='required'>Title*:</p><input type='text' name='title'><br><br>
						 Post Body (optional):<br><textarea name='body' rows='5' cols='40'></textarea><br><br>
						 <p class='required'>Photo Path*:</p><input type='text' name='link'><br><br>
						 Flavortext:<br><input type='text' name='flavor'><br><br>";
				}else{
					echo"Author:<br><input type='text' name='author'><br><br>
						 <p class='required'>Title*:</p><input type='text' name='title'><br><br>
						 <p class='required'>Post Body*:</p><textarea name='body' rows='5' cols='40'></textarea><br><br>";
				}

	echo"
					<input type='submit'>
				</form>";
		if($type == 1){
			if(isset($_REQUEST['photographer'])&&isset($_REQUEST['title'])&&isset($_REQUEST['link'])){
				if(!isset($_REQUEST['flavor'])){
						$_REQUEST['flavor'] = $_REQUEST['photographer'];
				}
				insertPic($_REQUEST['photographer'], $_REQUEST['title'], $_REQUEST['body'], $_REQUEST['link'], $_REQUEST['flavor']);
				echo"Picture added!<br>";
			}else if (isset($_REQUEST['photographer'])||isset($_REQUEST['title'])||isset($_REQUEST['link'])){
				echo"Picture not added, please fill all the required fields!<br>";
			}
		}else{
			if(isset($_REQUEST['title'])&&isset($_REQUEST['body'])){
				if(!isset($_REQUEST['author'])){
					$_REQUEST['author'] = 'Anonymous';
				}
				insertBlogPost($_REQUEST['author'], $_REQUEST['title'], $_REQUEST['body']);
				echo"Post added!<br>";
			}else if(isset($_REQUEST['title'])||isset($_REQUEST['body'])){
				echo"Post not added, please fill all the required fields!<br>";
			}
		}
		home();
	echo	"</body>
		</html>
	";
