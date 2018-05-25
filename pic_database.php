<?php
	include('config/config.php');
	include('include/db_query.php');

	// InsertPic('Wes Hicks', '2018-05-25', 'TestPic', 'pictures/0f191f-wes-hicks-464614-unsplash.jpg', 'flavortext');
	$pic = GetPic($_REQUEST['picID']);
	//var_Dump($pic);
	DisplayPic($pic);
	// echo"<img src='pictures/0f191f-wes-hicks-464614-unsplash.jpg'alt='".$pic['flavor']."'>";


	function InsertPic($photographer, $date, $title, $link, $flavor){
			$result = dbQuery("
				INSERT INTO pics (photographer, date, title, link, flavor)
				VALUES('$photographer', '$date', '$title', '$link', '$flavor')
			")->fetch();
		}

		function GetPic($picID){
			$result = dbQuery("
				SELECT *
				FROM pics
				WHERE picID = $picID
			")->fetch();
			return $result;
		}

		function DeletePic($picID){
			$result = dbQuery("
				DELETE FROM pics
				WHERE postID = $picID
			")->fetch();
		}

		function GetAllPics($picID){
			$result = dbQuery("
				SELECT *
				FROM pics
			")->fetch();
			return $result;
		}

		function DisplayPic($pic){
			echo"
			<html>
				<head>
					<title>".$pic['title']."</title>
					<link rel='stylesheet' href='style.css'>
				</head>
				<body>
					<h1>".$pic['title']."</h1>
					<h2>by ".$pic['photographer']."</h2>
					<h3>date: ".$pic['date']."</h3>
					<div>
						<img src='".$pic['link']."'alt='".$pic['flavor']."'>
					</div>
					<a href='index.html'>back to home</a>
				</body>
			</html>
			";
		}
