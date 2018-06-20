<?php
	//BOOK FUNCTIONS
	function validateBook($i){
		$errors = array();
		$errors+=validateTextField('bookTitle'.$i);
		$errors+=validateTextField('bookAuthor'.$i);
		$errors+=validateTextField('bookNotes'.$i);
		return $errors;
	}

	function addBook(){
		dbQuery("
			INSERT
			INTO
			VALUES()
		", array(''=>, ''=>))->fetchAll();
	}
