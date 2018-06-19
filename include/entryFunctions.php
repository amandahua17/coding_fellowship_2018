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
		return $errors;
	}

	function validatePhoto($i){
		$errors = array();
		return $errors;
	}

	function validatePerson($i){
		$errors = array();
		return $errors;
	}

	function validateBook($i){
		$errors = array();
		return $errors;
	}

	function validateMeal($i){
		$errors = array();
		return $errors;
	}

	function validateOccasion($i){
		$errors = array();
		return $errors;
	}

	function validateProject($i){
		$errors = array();
		return $errors;
	}
