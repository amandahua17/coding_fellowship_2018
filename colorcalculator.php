<?php
	$combined = "fff";

	if(isset($_REQUEST['color1'])&&isset($_REQUEST['color2'])){
		//$combined=(unpack('I',$_REQUEST['color1'])['int'])+(unpack('I', $_REQUEST['color2'])['int']);
		$combined=$_REQUEST['color1'];
	}
	echo "

		<style>
		body{
			background-color: #$combined;
		}
		</style>
		<form action=''>
			<select name = 'color1'>
				<option value='0xf00'>red</option>
				<option value='0x0f0'>green</option>
				<option value='0x00f'>blue</option>
				<option value='0x000'>black</option>
				<option value='0xfff'>white</option>
				<option value='0xff0'>yellow</option>
				<option value='0xf0f'>magenta</option>
				<option value='0x0ff'>aqua</option>
			</select>
			<select name = 'color2'>
				<option value='f00'>red</option>
				<option value='0f0'>green</option>
				<option value='00f'>blue</option>
				<option value='000'>black</option>
				<option value='fff'>white</option>
				<option value='ff0'>yellow</option>
				<option value='f0f'>magenta</option>
				<option value='0ff'>aqua</option>
			</select>
			<input type = 'submit' />
		</form>
	";



?>
