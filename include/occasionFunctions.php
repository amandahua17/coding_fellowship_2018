<?php
	//OCCASION FUNCTIONS
	function validateOccasion($i){
		$errors = array();
		$errors+=validateTextField('occasionName'.$i);
		$errors+=validateTextField('occasionDescription'.$i);
		return $errors;
	}

	// function addOccasion(){
	// 	dbQuery("
	// 		INSERT
	// 		INTO
	// 		VALUES()
	// 	", array(''=>, ''=>))->fetchAll();
	// }
