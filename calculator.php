<?php

	function add($variable1, $variable2){
		return($variable1+$variable2);
	}


	echo "
		<form action=''>
			<input type = 'text' name='variable1' />
			<input type = 'text' name='variable2' />
			<input type = 'submit' />
		</form>
	";

	if(isset($_REQUEST['variable1'])){
		echo "answer: ".add($_REQUEST['variable1'], $_REQUEST['variable2']);
	}
?>
