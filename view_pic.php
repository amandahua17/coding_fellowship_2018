<?php
	include('include/databaseFunctions.php');

	// InsertPic('Wes Hicks', '2018-05-25', 'TestPic', 'pictures/0f191f-wes-hicks-464614-unsplash.jpg', 'flavortext');
	$pic = GetPic($_REQUEST['picID']);
	//var_Dump($pic);
	DisplayPic($pic);
	// echo"<img src='pictures/0f191f-wes-hicks-464614-unsplash.jpg'alt='".$pic['flavor']."'>";
