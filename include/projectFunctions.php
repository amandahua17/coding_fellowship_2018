<?php
	//PROJECT FUNCTIONS
	function validateProject($i){
		$errors = array();
		$errors+=validateTextField('projectTitle'.$i);
		$errors+=validateTextField('projectProgress'.$i);
		$errors+=validateTextField('projectPartners'.$i);
		$errors+=validateTextField('projectNotes'.$i);
		return $errors;
	}

	// function addProject(){
	// 	dbQuery("
	// 		INSERT
	// 		INTO
	// 		VALUES()
	// 	", array(''=>, ''=>))->fetchAll();
	// }
