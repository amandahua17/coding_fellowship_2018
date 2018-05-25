<?php

	function add($variable1, $variable2){
		return($variable1+$variable2);
	}


	echo "
		<form action=''>
			<input type = 'text' name='variable1' />
			<select name = 'operation'>
				<option value='+'>+</option>
				<option value='-'>-</option>
				<option value='*'>*</option>
				<option value='/'>/</option>
				<option value='%'>%</option>
			</select>
			<input type = 'text' name='variable2' />
			<input type = 'submit' />
		</form>
	";

	if(isset($_REQUEST['variable1'])){
		if ($_REQUEST['operation'] == '+'){
			$answer = $_REQUEST['variable1'] + $_REQUEST['variable2'];
		}
		if ($_REQUEST['operation'] == '-'){
			$answer = $_REQUEST['variable1'] - $_REQUEST['variable2'];
		}
		if ($_REQUEST['operation'] == '*'){
			$answer = $_REQUEST['variable1'] * $_REQUEST['variable2'];
		}
		if ($_REQUEST['operation'] == '/'){
			$answer = $_REQUEST['variable1'] / $_REQUEST['variable2'];
		}
		if ($_REQUEST['operation'] == '%'){
			$answer = $_REQUEST['variable1'] % $_REQUEST['variable2'];
		}
		echo"$_REQUEST[variable1] $_REQUEST[operation] $_REQUEST[variable2] = $answer";
	}
?>
