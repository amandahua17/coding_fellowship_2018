<?php

	date_default_timezone_set('America/Chicago');

	include('config/config_local.php');
	include('include/db_query.php');

	include('include/htmlFunctions.php');
	include('include/userFunctions.php');
	include('include/entryFunctions.php');
	include('include/songFunctions.php');
	include('include/photoFunctions.php');
	include('include/bookFunctions.php');
	include('include/occasionFunctions.php');
	include('include/personFunctions.php');
	include('include/mealFunctions.php');
	include('include/projectFunctions.php');
	include('include/formFunctions.php');
	include('include/timelineFunctions.php');
	include('include/dateFunctions.php');

	session_start();
	// file_uploads = On;
