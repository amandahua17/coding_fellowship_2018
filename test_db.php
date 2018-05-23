<?php

	include('config/config.php');
	include('include/db_query.php');

	$result = dbQuery("SELECT COUNT(*) FROM inventory")->fetch();

	var_dump($result);
