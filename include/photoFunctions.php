<?php
	//PHOTO FUNCTIONS
	function validatePhoto($i){
		$errors = array();
		$errors+=validateTextField('photoPath'.$i);
		$errors+=validateTextField('photographer'.$i);
		// $errors+=validateTextField('photoTitle');	//OPTIONAL
		return $errors;
	}

	function addPhoto(){
		dbQuery("
			INSERT
			INTO
			VALUES()
		", array(''=>, ''=>))->fetchAll();
	}
