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

	function getLastEntryid(){
		$result = dbQuery("
			SELECT LAST_INSERT_ID()
			AS entryid;
		")->fetch();
		return $result['entryid'];
	}

	function addEntry($songs, $photos, $people, $occasions, $meals, $books, $projects, $freewrite, $date){
		dbQuery("
			INSERT INTO entries
			(userid)
			VALUES(:userid)
		", array('userid'=>$_SESSION['userid']))->fetchAll();
		$entryid = getLastEntryid();
		foreach($songs as $song){
			addSong($song, $entryid);
		}

		foreach($photos as $photo){
			addPhoto($photo, $entryid);
		}

		foreach($people as $person){
			addPerson($person, $entryid);
		}

		foreach($occasions as $occasion){
			addOccasion($occasion, $entryid);
		}

		foreach($meals as $meal){
			addMeal($meal, $entryid);
		}

		foreach($books as $book){
			addBook($book, $entryid);
		}

		foreach($projects as $project){
			addProject($project, $entryid);
		}
	}
