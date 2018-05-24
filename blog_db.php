<?php

	// NULL = 0, SOH = 1

	include('config/config.php');
	include('include/db_query.php');

	function InsertBlogPost($title, $h1, $h2, $h3, $body, $sugg, $ol, $ul, $links){
		$result = dbQuery("
			INSERT INTO blogposts (title, header1, header2, header3, body, sugg, ol, ul, links)
			VALUES('$title', '$h1', '$h2', '$h3', '$body', '$sugg', '$ol', '$ul', '$links')
		")->fetch();
	}

	function GetBlogPost($postID){
		$result = dbQuery("
			SELECT *
			FROM blogposts
			WHERE postID = $postID
		")->fetch();
		return $result;
	}

	// InsertBlogPost('about',
	// 'about',
	// 'the website',
	// '',
	// 'the goal of this website is to create a space where people can come to relieve stress or calm down whenever necessary.<br>having access to a site where many if not all resources are congregated (like this one, hopefully)',
	// NULL,
	// NULL,
	// NULL,
	// SOH);


	function DeleteBlogPost($postID){
		$result = dbQuery("
			DELETE FROM blogposts
			WHERE postID = $postID
		")->fetch();
	}
