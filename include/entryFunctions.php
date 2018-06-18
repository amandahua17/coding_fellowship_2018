<?php
	//ENTRY FUNCTIONS

	function getDayEntries($date){
		$result = dbQuery("
			SELECT *
			FROM entries
			WHERE date = :date
			AND userid = :userid
		", array('date'=>$date, 'userid'=>$_SESSION['userid']))->fetchAll();
		return $result;
	}

	function displayDayEntries(){
		
	}
