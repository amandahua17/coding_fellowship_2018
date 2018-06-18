<?php
	include('include/include_all.php');

	if(isset($_REQUEST['sub'])){
		header("Location: /account/user_settings.php?option=$_REQUEST[setting]");
	}

	$val = '';
	if(isset($_REQUEST['option'])){
		$val = $_REQUEST['option'];
	}

	head('User Settings');

	userTimelineLink();

	echo"
		<form method='post'>
			<select name='setting'>";
	echo"		<option value='0'";
	if($val == 0){
		echo" selected";
	}
	echo">-</option>
				<option value='1'";
	if($val == 1){
		echo" selected";
	}
	echo">Change Username</option>
				<option value='2'";
	if($val == 2){
		echo" selected";
	}
	echo">Change Password</option>
				<option value='3'";
	if($val == 3){
		echo" selected";
	}
	echo">Change Theme</option>
			</select><br><br>
			<input type='submit' value='Go' name='sub'>
		</form>
	";
	if(isset($_REQUEST['option'])){
		switch($_REQUEST['option']){
			case 0:
				echo"<p class='required'>Please select an option.</p>";
				break;
			case 1:
				echo"<p></p>";
				changeUsernameForm();
				break;
			case 2:
				echo"<p></p>";
				changePasswordForm();
				break;
			case 3:
				echo"<p></p>";
				changeThemeForm();
				break;
			case 5:
				header("Location: /index.php");
				break;
			case 6:
				echo"<p>Settings Updated!</p>";
				break;
			default:
				echo"<p class='required'>Please select an option.</p>";
				break;
		}
	}

	foot();
