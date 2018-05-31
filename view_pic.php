<?php
	include('include/include_all.php');

	if($_REQUEST['postID'] == '0'){
		foreach(GetAllPics() as $pic){
			DisplayPic($pic);
		}
	}else{
		$pic = GetPost($_REQUEST['postID']);
		//var_Dump($pic);
		DisplayPic($pic);
		showDelete($pic['postID']);
		// echo"<img src='pictures/0f191f-wes-hicks-464614-unsplash.jpg'alt='".$pic['flavor']."'>";
	}
	home();
