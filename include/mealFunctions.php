<?php
	//MEAL FUNCTIONS
	function validateMeal($i){
		$errors = array();
		$errors+=validateTextField('mealPlace'.$i);
		$errors+=validateTextField('mealChef'.$i);
		$errors+=validateTextField('mealDescription'.$i);
		return $errors;
	}

	function addMeal(){
		dbQuery("
			INSERT
			INTO
			VALUES()
		", array(''=>, ''=>))->fetchAll();
	}
