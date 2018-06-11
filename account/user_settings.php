<?php
	include('/include/include_all.php');

	if(isset($_REQUEST['sub'])){
		header("Location: /account/user_settings.php?option=$_REQUEST[setting]");
	}

	Heading("User Settings", "User Settings");

	$val = '';
	if(isset($_REQUEST['option'])){
		$val = $_REQUEST['option'];
	}
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
	echo">Add/Change Nickname</option>
				<option value='4'";
	if($val == 4){
		echo" selected";
	}
	echo">Deactivate Account</option>
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
				ChangeUsernameForm();
				break;
			case 2:
				echo"<p></p>";
				ChangePasswordForm();
				break;
			case 3:
				echo"<p></p>";
				NicknameForm();
				break;
			case 4:
				echo"<p></p>";
				DeactivateAccountForm();
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

	Footer();
