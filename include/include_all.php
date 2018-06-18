<?php

	date_default_timezone_set('America/Chicago');

	include('/config/config.php');
	include('/include/db_query.php');

	include('/include/htmlFunctions.php');
	include('/include/userFunctions.php');
	include('/include/entryFunctions.php');
	include('/include/songFunctions.php');
	include('/include/photoFunctions.php');
	include('/include/bookFunctions.php');
	include('/include/eventFunctions.php');
	include('/include/formFunctions.php');
	include('/include/timelineFunctions.php');
	include('/include/dateFunctions.php');

	session_start();
