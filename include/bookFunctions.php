<?php
	//BOOK FUNCTIONS
	function validateBook($i){
		$errors = array();
		$errors+=validateTextField('bookTitle'.$i);
		$errors+=validateTextField('bookAuthor'.$i);
		$errors+=validateTextField('bookNotes'.$i);
		return $errors;
	}

	function addBook($book, $entryid){
		if(!isset($book['bookNotes'])){
			$book['bookNotes'] = NULL;
		}
		dbQuery("
			INSERT INTO books
			(entryid, title, author, notes)
			VALUES(:entryid, :title, :author, :notes)
		", array('entryid'=>$entryid,
				'title'=>$book['bookTitle'],
				'author'=>$book['bookAuthor'],
				'notes'=>$book['bookNotes'])
		)->fetchAll();
	}
