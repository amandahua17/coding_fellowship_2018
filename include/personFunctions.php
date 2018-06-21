<?php
	//PERSON FUNCTIONS
	function validatePerson($i){
		$errors = array();
		$errors+=validateTextField('personName'.$i);
		// $errors+=validateTextField('personRelationship');	//OPTIONAL
		$errors+=validateTextField('personDescription'.$i);
		return $errors;
	}

	// function addPerson(){
	// 	dbQuery("
	// 		INSERT
	// 		INTO
	// 		VALUES()
	// 	", array(''=>, ''=>))->fetchAll();
	// }
