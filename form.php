<?php

function submitApplication($name, $position, $phone){
	die("
		<h1>
			$name just applied
		</h1>
		<p>
			They applied for the $position position and
			you can reach them at $phone
		</p>
	");
}

$errors = array();
if(isset($_REQUEST['JobApplication'])){
	if(!$_REQUEST['Name']){		//not set gives empty string, NOT null
		$errors['Name'] = "required";
	}
	if(!$_REQUEST['Phone']){
		$errors['Phone'] = "required";
	}
	if(!$_REQUEST['Position']){
		$errors['Position'] = "required";
	}
	if(sizeof($errors) == 0){
		submitApplication(
			$_REQUEST['Name'],
			$_REQUEST['Position'],
			$_REQUEST['Phone']
		);
	}
}

echo "
<h1>
        Job Application Form
</h1>";
	if(sizeof($errors)>0){
		echo"<p style = 'color:red'>PLEASE FILL REQUIRED FIELDS</p>";
	}
echo"
<form action='' method='post'>
        Name*:
        <input type='text' name='Name' value='$_REQUEST[Name]'/><br />

        Phone*:
        <input type='text' name='Phone' value='$_REQUEST[Phone]'/><br />

        Position*:
        <select name='Position' value='$_REQUEST[Position]'>
                <option value=''>-</option>
                <option value='Fellow'>Coding fellow</option>
                <option value='DevIntern'>Developer intern</option>
                <option value='CrmcIntern'>CRM coach intern</option>
                <option value='Dev'>Full-time developer</option>
                <option value='Crmc'>Full-time CRM coach</option>
        </select>

        <br/><br/>
        <input type='submit' name='JobApplication' value='Submit your application' />
</form>
";
