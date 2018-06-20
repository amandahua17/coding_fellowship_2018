<?php
	//SONG FUNCTIONS
	function validateSong($i){
		$errors = array();
		$errors+=validateTextField('songTitle'.$i);
		$errors+=validateTextField('songArtist'.$i);
		// $errors+=validateTextField('songLink');		//OPTIONAL
		return $errors;
	}

	function addSong($song){
		dbQuery("
			INSERT INTO
			(userid, )
			VALUES(:userid)
		", array(''=>, ''=>))->fetchAll();
	}
