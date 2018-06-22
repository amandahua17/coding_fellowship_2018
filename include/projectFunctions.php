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

	function addProject($project, $entryid){
		dbQuery("
			INSERT INTO projects
			(entryid, title, progress, partners, notes)
			VALUES(:entryid, :title, :progress, :partners, :notes)
		", array('entryid'=>$entryid,
				'title'=>$project['projectTitle'],
				'progress'=>$project['projectProgress'],
				'partners'=>$project['projectPartners'],
				'notes'=>$project['projectNotes'])
		)->fetchAll();
	}
