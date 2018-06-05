<?php
	include('/include/include_all.php');

	$postID = $_REQUEST['postID'];

	EditPostForm($postID);

	Home();
