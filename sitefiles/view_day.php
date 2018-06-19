<?php
	include('/include/include_all.php');

	head('View Day');

	addEntryButton();

	echo"
		<div id='addentryform'>
			<form method='post'>
	";
				formTextField('freeWrite','Free Write');

	echo"
				<select id='newOption'>
					<option>-</option>
					<option value='song'>song</option>
					<option value='photo'>photo</option>
					<option value='person'>person</option>
					<option value='occasion'>occasion</option>
					<option value='meal'>meal</option>
					<option value='book'>book</option>
					<option value='project'>project</option>
				</select>
				<button type='button' onclick='addOption()'>add field</button><br><br>
				<input type='submit' name='addEntrySub' value='Add Entry' id='placeOptionsBeforeThis'>
			</form>
		</div>
	";

	foot();
