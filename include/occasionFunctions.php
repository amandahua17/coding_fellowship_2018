<?php
	//OCCASION FUNCTIONS
	function validateOccasion($i){
		$errors = array();
		$errors+=validateTextField('occasionName'.$i);
		$errors+=validateTextField('occasionDescription'.$i);
		return $errors;
	}

	function addOccasion($occasion, $entryid){
		dbQuery("
			INSERT INTO occasions
			(entryid, name, description)
			VALUES(:entryid, :name, :description)
		", array('entryid'=>$entryid,
				'name'=>$occasion['occasionName'],
				'description'=>$occasion['occasionDescription'])
		)->fetchAll();
	}

	function getNextArrayOccasion($i){
		$occasions = array();
		$occasions[$i]['occasionName'] = $_REQUEST['occasionName'.$i];
		$occasions[$i]['occasionDescription'] = $_REQUEST['occasionDescription'.$i];
		return $occasions;
	}
