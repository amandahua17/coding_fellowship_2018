<?php
	include('/include/include_all.php');

	head('View Day');

	addEntryButton();

	echo"
		<div id='addEntryForm'>
			<form method='post'>
	";
				formTextField();
	echo"
				<input type='submit' name='addEntrySub'>
			</form>
		</div>
	";

	foot();
