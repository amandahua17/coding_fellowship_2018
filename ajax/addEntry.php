<?php
	//Handles adding entries, request from jsfunctions's Post request validateEntryForm()

	include ('include/include_all.php');

	$errors = array();
	// if(isset($_REQUEST['add'])){		//if want to add entry
	// echo'addEntrySub pressed';
	// var_dump($_REQUEST);
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
		echo('!!!!!!!!!!!!!!!!!!!!!!!add entry!!!!!!!!!!!!!!!!!!!!!!!!');
		// addEntry($songs, $photos, $people, $occasions, $meals, $books, $projects, $_REQUEST['freeWrite'], $_REQUEST['date']);
	}else{
		foreach($errors as $key=>$error){
			echo $key, ' ', $error;
		}
	}
	// }
