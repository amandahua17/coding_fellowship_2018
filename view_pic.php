<?php
	include('include/databaseFunctions.php');

	// InsertPic('Wes Hicks', 'TestPic', 'pictures/0f191f-wes-hicks-464614-unsplash.jpg', 'flavortext');
	$pic = GetPost($_REQUEST['postID']);
	//var_Dump($pic);
	DisplayPic($pic);
	// echo"<img src='pictures/0f191f-wes-hicks-464614-unsplash.jpg'alt='".$pic['flavor']."'>";
