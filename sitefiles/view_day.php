<?php
	include('include/include_all.php');
	// var_dump($_REQUEST);
	// die();
	$errors = array();
	if(isset($_REQUEST['add'])){		//if want to add entry
		echo'addEntrySub pressed';
		var_dump($_REQUEST);
		// return;
		$errors+=validateTextField('freewrite');
		//SONG
		$songcount = $_REQUEST['songs'];
		$songs = array();
		for($i=0; $i<$songcount; $i++){
			$errors+=validateSong($i);
			$songs+=getNextArraySong($i);
		}
		//PHOTO
		$photocount = $_REQUEST['photos'];
		$photos = array();
		for($i=0; $i<$photocount; $i++){
			$errors+=validatePhoto($i);
			$photos+=getNextArrayPhoto($i);
		}

		//PERSON
		$personcount = $_REQUEST['people'];
		$people = array();
		for($i=0; $i<$personcount; $i++){
			$errors+=validatePerson($i);
			$people+=getNextArrayPerson($i);
		}

		//OCCASION
		$occasioncount = $_REQUEST['occasions'];
		$occasions = array();
		for($i=0; $i<$occasioncount; $i++){
			$errors+=validateOccasion($i);
			$occasions+=getNextArrayOccasion($i);
		}

		//MEAL
		$mealcount = $_REQUEST['meals'];
		$meals = array();
		for($i=0; $i<$mealcount; $i++){
			$errors+=validateMeal($i);
			$meals+=getNextArrayMeal($i);
		}

		//BOOK
		$bookcount = $_REQUEST['books'];
		$books = array();
		for($i=0; $i<$bookcount; $i++){
			$errors+=validateBook($i);
			$books+=getNextArrayBook($i);
		}

		//PROJECT
		$projectcount = $_REQUEST['projects'];
		$projects = array();
		for($i=0; $i<$projectcount; $i++){
			$errors+=validateProject($i);
			$projects+=getNextArrayProject($i);
		}

		//VALIDATION
		if(sizeof($errors)==0){
			echo('add entry!');
			// addEntry($songs, $photos, $people, $occasions, $meals, $books, $projects, $_REQUEST['freewrite'], $_REQUEST['date']);
		}else{
			displayErrors($errors);
		}
	}

	head('View Day');

	addEntryButton();

	echo"
		<div id='addentryform'>
			<form method='post'>
	";
				formTextField('freeWrite','Free Write');

	echo"
				<select id='newOption'>
					<option>-</option>
					<option value='song'>song</option>
					<option value='photo'>photo</option>
					<option value='person'>person</option>
					<option value='occasion'>occasion</option>
					<option value='meal'>meal</option>
					<option value='book'>book</option>
					<option value='project'>project</option>
				</select>
				<button type='button' onclick='addOption()'>add field</button><br><br>
				<input type='button' onclick='validateEntryForm()' name='addEntrySub' value='Add Entry' id='placeOptionsBeforeThis'>
			</form>
		</div>
	";

	foot();
