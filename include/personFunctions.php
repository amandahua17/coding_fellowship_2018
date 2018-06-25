<?php
	//PERSON FUNCTIONS
	function validatePerson($i){
		$errors = array();
		$errors+=validateTextField('personName'.$i);
		// $errors+=validateTextField('personRelationship');	//OPTIONAL
		$errors+=validateTextField('personDescription'.$i);
		return $errors;
	}

	function addPerson($person, $entryid){
		dbQuery("
			INSERT INTO people
			(entryid, name, relationship, description)
			VALUES(:entryid, :name, :relationship, :description)
		", array('entryid'=>$entryid,
				'name'=>$person['personName'],
				'relationship'=> $person['personRelationship'],
				'description'=>$person['personDescription'])
		)->fetchAll();
	}

	function getNextArrayPerson($i){
		$people = array();
		$people[$i]['personName'] = $_REQUEST['personName'.$i];
		$people[$i]['personRelationship'] = $_REQUEST['personRelationship'.$i];
		$people[$i]['personDescription'] = $_REQUEST['personDescription'.$i];
		return $people;
	}
