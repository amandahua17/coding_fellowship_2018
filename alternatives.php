

<?php
	$listNum = 2;
	$switch = false;
 ?>
<html>
	<head>
		<title>list</title>
		<link rel='stylesheet' href='style.css'/>

	</head>
	<body class='bg'>
		<h1>suggestions for calming</h1>
		<div>
			<h2>alternatives to self harm:</h2>
			<ol>
				<li>draw lines or doodles where you want to cut</li><br>
				<li>play some loud music<br>
					(suggested playlists: <a target='_blank'href='https://open.spotify.com/user/spotify/playlist/37i9dQZF1DX4fpCWaHOned?si=YbaxeAjaTcGqWhClPaMMkA'>Spotify playlist</a>)</li><br>
			</ol>
			<?php
					//$placeholder = $_REQUEST['suggestion'];
					//$REQUEST['suggestion'] = NULL;
					if(isset($_REQUEST['suggestion'])){
						$listNum++;
						echo"
							$listNum. $_REQUEST[suggestion]<br\>
						";
					}
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
