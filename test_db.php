<?php

	include('config/config.php');
	include('include/db_query.php');


	$allInventoryItems = GetAllInventoryItems();
	$single = GetInventoryItem(3);

	echo"<pre>";
	var_dump($single);
	echo"</pre>";

	function InsertInventoryItem($name, $description, $category){
		$result = dbQuery("
			INSERT INTO Inventory (name, description, category)
			VALUES('$name', '$description', '$category')

		")->fetch();
	}

	function GetAllInventoryItems(){
		$result = dbQuery("
			SELECT *
			FROM inventory
		")->fetchAll();

		return $result;	//returns 2d array
	}

	function GetInventoryItem($id){
		$result = dbQuery("
			SELECT *
			FROM inventory
			WHERE inventoryID = :inventoryID
		", array(
			'inventoryID'=>$id


		))->fetch();
		return $result;
	}
	
