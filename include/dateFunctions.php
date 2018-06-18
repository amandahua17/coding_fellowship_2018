<?php
	function getAllDates(){
		$result = dbQuery("
			SELECT date
			FROM dates
			INNER JOIN users ON dates.userid = users.userid
			WHERE users.userid = :userid
		", array('userid'=>$_SESSION['userid']))->fetchAll();
		return $result;
	}

	function getDateNumEntries($array, $date){
		$count = 0;
		foreach($array as $datetest){
			if($datetest == $date){
				$count++;
			}
		}
		return $count;
	}
