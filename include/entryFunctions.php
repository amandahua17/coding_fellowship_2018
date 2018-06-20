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

	function addEntry(){

	}

	//VALIDATION FUNCTIONS
	function validateSong($i){
		$errors = array();
		$errors+=validateTextField('songTitle');
		$errors+=validateTextField('songArtist');
		// $errors+=validateTextField('songLink');		//OPTIONAL
		return $errors;
	}

	function validatePhoto($i){
		$errors = array();
		$errors+=validateTextField('photoPath');
		$errors+=validateTextField('photographer');
		// $errors+=validateTextField('photoTitle');	//OPTIONAL
		return $errors;
	}

	function validatePerson($i){
		$errors = array();
		$errors+=validateTextField('personName');
		// $errors+=validateTextField('personRelationship');	//OPTIONAL
		$errors+=validateTextField('personDescription');
		return $errors;
	}

	function validateBook($i){
		$errors = array();
		$errors+=validateTextField('bookTitle');
		$errors+=validateTextField('bookAuthor');
		$errors+=validateTextField('bookNotes');
		return $errors;
	}

	function validateMeal($i){
		$errors = array();
		$errors+=validateTextField('mealPlace');
		$errors+=validateTextField('mealChef');
		$errors+=validateTextField('mealDescription');
		return $errors;
	}

	function validateOccasion($i){
		$errors = array();
		$errors+=validateTextField('occasionName');
		$errors+=validateTextField('occasionDescription');
		return $errors;
	}

	function validateProject($i){
		$errors = array();
		$errors+=validateTextField('projectTitle');
		$errors+=validateTextField('projectProgress');
		$errors+=validateTextField('projectPartners');
		$errors+=validateTextField('projectNotes');
		return $errors;
	}
