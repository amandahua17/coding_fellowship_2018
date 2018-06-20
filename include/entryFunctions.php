<?php
	//ENTRY FUNCTIONS

	function getDayEntries($date){
		$result = dbQuery("
			SELECT *
			FROM entries
			WHERE date = :date
			AND userid = :userid
			ORDER BY date DESC;
		", array('date'=>$date, 'userid'=>$_SESSION['userid']))->fetchAll();
		return $result;
	}

	function displayDayEntries(){

	}

	function addEntry($songs, $photos, $people, $occasions, $meals, $books, $projects, $freewrite, $date, $entryid){
		foreach($songs as $song){
			addSong($song)
		}

		foreach($photos as $photo){

		}

		foreach($people as $person){

		}

		foreach($occasions as $occasion){

		}

		foreach($meals as $meal){

		}

		foreach($books as $book){

		}

		foreach($projects as $project){

		}
		dbQuery("
			INSERT INTO entries
			(userid)
			VALUES(:userid)
		", array('userid'=>$_SESSION['userid'], ''=>))->fetchAll();
	}
