<?php
	//MEAL FUNCTIONS
	function validateMeal($i){
		$errors = array();
		$errors+=validateTextField('mealPlace'.$i);
		$errors+=validateTextField('mealChef'.$i);
		$errors+=validateTextField('mealDescription'.$i);
		return $errors;
	}

	function addMeal($meal, $entryid){
		dbQuery("
			INSERT INTO meals
			(entryid, place, chef, description)
			VALUES(:entryid, :place, :chef, :description)
		", array('entryid'=>$entryid,
				'place'=>$meal['mealPlace'],
				'chef'=>$meal['mealChef'],
				'description'=>$meal['mealDescription'])
		)->fetchAll();
	}
