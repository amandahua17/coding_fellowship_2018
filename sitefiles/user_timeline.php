<?php
	include('include/include_all.php');
	$errors = array();
	if(isset($_REQUEST['dateSub'])){
		$errors+=validateDateField('date');
		var_dump($_REQUEST['date'], getBeginningDate());
		// die();
		if($_REQUEST['date']<getBeginningDate()){
			$early = true;
		}
		if(sizeof($errors)==0){
			if($early){
				header('Location: view_day.php?date='.$_REQUEST['date'].'&early=true');
			}else{
				header('Location: view_day.php?date='.$_REQUEST['date']);
			}
		}else{
			displayErrors($errors);
		}
	}

	head('Your Timeline');
	echo"<form method='post'>
			";
			formDateField('date', 'Go To');
	echo"</form>
	";

	displayTimeline($_SESSION['userid']);



	foot();
