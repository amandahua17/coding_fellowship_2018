<?php
	echo"
		$_POST
	";



	$posts=array(
		'list'=>array(
			'title'=>'list',
			'header1'=>'suggestions for calming',
			'p'=>'the author of this page has written down a personal list of steps for feeling better.<br>
			we note that not everyone works the same way, and this is only a list of suggestions. feel free to add to the list below.',
			'listelement'=> array("give yourself a short period of time to wallow in negative feeling<br>(suggested times: 5 minutes, 15 minutes)",
				"take a shower",
				"play some upbeat music<br>
				(suggested playlists: <a target='_blank'href='https://open.spotify.com/user/22k343m6upq3jz5sylnsoshsa/playlist/55vFMBQnGhzfabmeExGle3?si=dAwY38qRQq6cJMbVQI07CQ'>Spotify playlist</a>)",
				"get dressed immediately, turn on the lights, eat something",
				"open the windows/shades",
				"drink some cold water",
				"if it's sunny, go outside"
			),
			'header2'=>'suggestions:',
			'header3'=>'personal suggestions'
		)
	);

	echo"
		<html>
			<head>
				<title>$_POST[title]</title>
				<link rel='stylesheet' href='style.css'/>

			</head>
			<body class='bg'>
				<h1>$_POST[header1]</h1>
				<div>
					<p>$_POST[p]</p>
					<h2>$_POST[listelement]</h2>
					<ol>

	";
	for($i=0;$i<count($suggestion);$i++){
		echo"
			<li>$suggestion[$i]</li><br>
		";
	}
	echo"
					</ol>
					<h3>$_POST[header3]</h3>
				</div>
				<a class='home' href='index.html'>back to home</a>
			</body>
		</html>
	";
 ?>
