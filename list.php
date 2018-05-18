

<?php
	$listNum = 7;
	$switch = false;
 ?>
<html>
	<head>
		<title>list</title>
		<link rel='stylesheet' href='style.css'/>

	</head>
	<body class='bg'>
		<h1>suggestions for calming</h1>
		<div class="infoSection">
			<p>the author of this page has written down a personal list of steps for feeling better. we note that not everyone works the same way, and this is only a list of suggestions. feel free to add to the list below.</p>
			<h2>suggestions:</h2>
			<p>1. give yourself a short period of time to wallow in negative feeling <br> (suggested times: 5 minutes, 15 minutes)<br><br>
			2. take a shower<br><br>
			3. play some upbeat music<br>(suggested playlists: <a target='_blank'href='https://open.spotify.com/user/22k343m6upq3jz5sylnsoshsa/playlist/55vFMBQnGhzfabmeExGle3?si=dAwY38qRQq6cJMbVQI07CQ'>Spotify playlist</a>)<br><br>
			4. get dressed immediately, turn on the lights, eat something<br><br>
			5. open the windows/shades<br><br>
			6. drink some cold water<br><br>
			7. if it's sunny, go outside<br><br>
			<?php
			/*	while(true){
					$placeholder = $_REQUEST['suggestion'];
					$REQUEST['suggestion'] = NULL;
					if($_REQUEST['suggestion'] != $placeholder){
						$listNum++;
						echo"
							$listNum. $placeholder<br\>
						";
					}
				}*/
			 ?>
			</p>
			<h3>personal suggestions</h3>
			<!--ADD A BOX HERE FOR SUGGESTIONS!!!!-->
			<!--<input style="text-align:center"type='text' id='sugg' name='suggestion' placeholder='suggest away'><br>
			<input style="text-align:center" type="submit" value="Suggest"><br>-->

			<form method="post">
				<input style="text-align:center"type='text' id='sugg' name='suggestion' placeholder='suggest away'><br>
				<input style="text-align:center" type="submit" value="Suggest"><br>
			</form>

		</div>
	   <a class="home" href="index.html">back to home</a>

	</body>
</html>
