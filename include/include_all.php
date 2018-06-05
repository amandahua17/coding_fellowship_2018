<?php
	date_default_timezone_set('America/Chicago');
	$root = $_SERVER['DOCUMENT_ROOT'];


	include($root.'/config/config.php');
	include($root.'/include/db_query.php');

	session_start();

	include($root.'/include/databaseFunctions_blog_pic.php');

	
