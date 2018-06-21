<?php
	include('include/include_all.php');

	$errors = array();
	if(isset($_REQUEST['addEntrySub'])){		//if want to add entry
		$errors+=validateTextField('freewrite');
		//SONG
		$songcount = $_REQUEST['songs'];
		for($i=0; $i<$songcount; $i++){
			$errors+=validateSong($i);
		}
		//PHOTO
		$photocount = $_REQUEST['photos'];
		for($i=0; $i<$photocount; $i++){
			$errors+=validatePhoto($i);
		}

		//PERSON
		$personcount = $_REQUEST['people'];
		for($i=0; $i<$personcount; $i++){
			$errors+=validatePerson($i);
		}

		//OCCASION
		$occasioncount = $_REQUEST['occasions'];
		for($i=0; $i<$occasioncount; $i++){
			$errors+=validateOccasion($i);

		}

		//MEAL
		$mealcount = $_REQUEST['meals'];
		for($i=0; $i<$mealcount; $i++){
			$errors+=validateMeal($i);

		}

		//BOOK
		$bookcount = $_REQUEST['books'];
		for($i=0; $i<$bookcount; $i++){
			$errors+=validateBook($i);

		}

		//PROJECT
		$projectcount = $_REQUEST['projects'];
		for($i=0; $i<$projectcount; $i++){
			$errors+=validateProject($i);

		}

		//VALIDATION
		if(sizeof($errors)==0){

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
