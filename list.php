

<?php
	session_start();
	$suggestion = array("give yourself a short period of time to wallow in negative feeling<br>(suggested times: 5 minutes, 15 minutes)",
	"take a shower",
	"play some upbeat music<br>
	(suggested playlists: <a target='_blank'href='https://open.spotify.com/user/22k343m6upq3jz5sylnsoshsa/playlist/55vFMBQnGhzfabmeExGle3?si=dAwY38qRQq6cJMbVQI07CQ'>Spotify playlist</a>)",
	"get dressed immediately, turn on the lights, eat something",
	"open the windows/shades",
	"drink some cold water",
	"if it's sunny, go outside");
 ?>
<html>
	<head>
		<title>list</title>
		<link rel='stylesheet' href='style.css'/>

	</head>
	<body class='bg'>
		<h1>suggestions for calming</h1>
		<div>
			<p>the author of this page has written down a personal list of steps for feeling better.<br>we note that not everyone works the same way, and this is only a list of suggestions. feel free to add to the list below.</p>
			<h2>suggestions:</h2>
			<ol>
				<?php
					if(isset($_POST['suggestion'])){
						var_dump($suggestion);
						array_push($suggestion, $_POST['suggestion']);
						var_dump($suggestion);
					}
					for($i=0;$i<count($suggestion);$i++){
						echo"
							<li>$suggestion[$i]</li><br>
						";
					}
					// global $i;
					// global $suggestion;
					// var_dump($i);
					// if(isset($_REQUEST['suggestion'])){
					// 	$suggestion[$i]=$_REQUEST['suggestion'];
					// 	// echo"
					// 	// 	<li>$_REQUEST[suggestion]</li><br>
					// 	// ";
					// 	var_dump($suggestion);
					// 	var_dump($i);
					// 	echo"<li>$suggestion[$i]</li><br>";
					// 	$i++;
					// 	var_dump($i);
					// }
					// // for($i=0;$i<12;$i++){
					// // 	echo"test<br><br>";
					// // 	var_dump($i);
					// // }
				 ?>
			</ol>
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
