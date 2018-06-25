<?php
	//PHOTO FUNCTIONS
	function validatePhoto($i){
		$errors = array();
		$errors+=validateTextField('photoPath'.$i);
		$errors+=validateTextField('photographer'.$i);
		// $errors+=validateTextField('photoTitle');	//OPTIONAL
		return $errors;
	}

	function addPhoto($photo, $entryid){
		if(!isset($photo['photoTitle'])){
			$photo['photoTitle'] = NULL;
		}
		dbQuery("
			INSERT INTO photos
			(entryid, path, photographer, title)
			VALUES(:entryid, :path, :photographer, :title)
		", array('entryid'=>$entryid,
				'path'=>$photo['photoPath'],
				'photographer'=>$photo['photographer'],
				'title'=>$photo['photoTitle'])
		)->fetchAll();
	}

	function getNextArrayPhoto($i){
		$photos = array();
		$photos[$i]['photoPath'] = $_REQUEST['photoPath'.$i];
		$photos[$i]['photographer'] = $_REQUEST['photographer'.$i];
		$photos[$i]['photoTitle'] = $_REQUEST['photoTitle'.$i];
		return $photos;
	}
