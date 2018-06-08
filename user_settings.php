<?php
	include('/include/include_all.php');

	if(isset($_REQUEST['sub'])){
		header("Location: /user_settings.php?option=$_REQUEST[setting]");
	}

	Heading("User Settings", "User Settings");

	SettingsForm();

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
