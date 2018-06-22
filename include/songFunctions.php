<?php
	//SONG FUNCTIONS
	function validateSong($i){
		$errors = array();
		$errors+=validateTextField('songTitle'.$i);
		$errors+=validateTextField('songArtist'.$i);
		// $errors+=validateTextField('songLink');		//OPTIONAL
		return $errors;
	}

	function addSong($song, $entryid){
		if(!isset($song['songLink'])){
			$song['songLink'] = NULL;
		}
		dbQuery("
			INSERT INTO songs
			(entryid, title, artist, link)
			VALUES(:entryid, :title, :artist, :link)
		", array('entryid'=>$entryid,
				'title'=>$song['songTitle'],
				'artist'=>$song['songArtist'],
				'link'=>$song['songLink'])
		)->fetchAll();
	}
