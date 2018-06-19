<?php

	function displayTimeline($userid){		//is userid necessary as a parameter? if signed in, only user should be allowed to view, then session should be accessible
		$dates = getAllDates();
		$count = 0;

		echo"
			<div class='container right'>
				<div class='content'>
				  <h2>TODAY: ".date('Y-m-d')."</h2>
				  <a href='view_day.php?date=".date('Y-m-d')."'>Add an entry</a>
				</div>
			</div>
		";

		foreach($dates as $date){
			if($count%2 == 0){
				echo"
					<div class='container left'>
						<div class='content'>
						  <h2>$date</h2>
						  <p>".getDateNumEntries($dates, $date)." Entries</p>
						  <a href='view_day.php?date=$date'>Add an entry</a>
						</div>
					</div>
				";
			}else{
				echo"
					<div class='container right'>
						<div class='content'>
						  <h2>$date</h2>
						  <p>".getDateNumEntries($dates, $date)."</p>
						  <a href='view_day.php?date=$date'>Add an entry</a>
						</div>
					</div>
				";
			}
			$count++;
		}

		echo"
			<a href='view_day.php?date=".getBeginningDate()."'>BEGINNING: ".getBeginningDate()."
		";
	}
