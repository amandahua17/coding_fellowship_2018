<?php
	include('/include/include_all.php');

	$postID = $_REQUEST['postID'];

	$post = GetPost($postID);
	$type = $post['postType'];
	$attributes = GetPostAttributeArray($postID);
	$errors = array();
	$edits = array();
	$tagString = '';

	if(isset($_REQUEST['cancel'])){
		if($type == 'pic'){
			header("Location: /view_pic.php?postID=".$postID);
			exit();
		}else if($type == 'blog'){
			header("Location: /view_post.php?postID=".$postID);
			exit();
		}
	}

	if(isset($_REQUEST['tagsub'])){
		$_REQUEST['tagString'].=",";
		$_REQUEST['tagString'].=$_REQUEST['tags'];
		// var_dump($_REQUEST, $tagarray);
		echo"tag added!";
	}

	if(isset($_REQUEST['deleteTag'])){
		// var_dump($_REQUEST);
		DeleteTagFromPost(GetTag($_REQUEST['deleteTag'])['tagID'], $postID);
	}

	if(isset($_REQUEST['tagString'])){
		$tagarray = explode(',', $_REQUEST['tagString']);
	}else{
		// $tagString = implode(',', GetAllTags($postID)['Array']);
		foreach(GetAllTags($postID) as $key=>$val){
			$tagString.=",";
			$tagString.=$val['tagname'];
		}
		$tagarray = explode(',', $tagString);
	}

	if(isset($_REQUEST['apply'])){
		if($type == 'pic'){
			$errors+=ValidateTextField('Photographer', $errors);
			$errors+=ValidateTextField('Title', $errors);
			$errors+=ValidateTextField('Link', $errors);
		}else if($type == 'blog'){
			$errors+=ValidateTextField('Title', $errors);
			$errors+=ValidateTextField('Body', $errors);
		}
		if(sizeof($errors) == 0){
			var_dump($_REQUEST);
			// var_dump($attributes, $_REQUEST);
			// die();
			// foreach($attributes as $key=>$attribute){
			// 	// var_dump($edits, $_REQUEST);
			// 	if($type == 'pic'){
			// 		if($attribute == 'Author'){		//must add exceptions
			// 			$edits['author'] = $_REQUEST['Photographer'];
			// 		}else if($attribute == 'Flavortext'){
			// 			$edits['flavor'] = $_REQUEST['Flavortext'];
			// 		}else{
			// 			$edits[$attribute] = $_REQUEST[$attribute];
			// 		}
			// 	}else{
			// 		$edits[$attribute] = $_REQUEST[$attribute];
			// 	}
			// }

			foreach($attributes as $key=>$attribute){
			//var_dump($edits, $_REQUEST);
			if($type == 'pic'){
				if($attribute == 'Author'){		//must add exceptions
					$_REQUEST['author'] = $_REQUEST['Photographer'];
				}else if($attribute == 'Flavortext'){
					$_REQUEST['flavor'] = $_REQUEST['Flavortext'];
				}else{
					$_REQUEST[$attribute] = $_REQUEST[$attribute];
				}
			}
		   }
			EditPost($postID, $_REQUEST, $tagarray);
			if($type == 'pic'){
				header("Location: /view_pic.php?postID=".$postID);
				exit();
			}else if($type == 'blog'){
				header("Location: /view_post.php?postID=".$postID);
				exit();
			}
		}
	}

	if(isset($_REQUEST['tagID'])){
		DeleteTagFromPost($_REQUEST['tagID'], $postID);
		header("Location: /edit_post.php?postID=".$postID);
	}

	//Form
	if($type == 'pic'){
		Heading("Edit Your Post", "Edit Your Picture Post");
	}else if ($type == 'blog'){
		Heading("Edit Your Post", "Edit Your Blog Post");
	}
			foreach($errors as $key=>$val){
				echo"<span style='color: red'>$key is a required field!<br></span>";
			}
	echo"		<form method='post' name='form'>";
				if($type== 'pic'){
					ShowTextField(true, 'Photographer', $post['author']);
					ShowTextField(true, 'Title', $post['title']);
					ShowTextField(false, 'Body', $post['body']);
					ShowTextField(true, 'Link', $post['link']);
					ShowTextField(false, 'Flavortext', $post['flavor']);
					echo"<a href='flavorInfo.php'>What is flavor text?</a><br>";


				}else if($type=='blog'){
					ShowTextField(false, 'Author', $post['author']);
					ShowTextField(true, 'Title', $post['title']);
					ShowTextField(true, 'Body', $post['body']);
				}
				ShowTagField();
				if(isset($_REQUEST['tagString'])){
					// var_dump($_REQUEST['tagString']);
					ShowHiddenField('tagString', @$_REQUEST['tagString']);
				}else{
					// var_dump($tagString);
					ShowHiddenField('tagString', @$tagString);
				}
				echo"<p>Tags: </p>";
				// global $j;
				// $j=0;
				foreach($tagarray as $tag){
					if(($tag!='')&&($tag!= NULL)){
						echo"<span id='tag'>#".$tag;
						echo" <a class='close' href='/edit_post.php?postID=".$postID."&tagID=".GetTag($tag)['tagID']."'>x</a></span>";
						// echo"<button onclick=closeTag() class='close' name='$j'>x</button></span>\t";
					}
					// $j++;
				}
	echo"			<br><br><input type='submit' name='apply' value='Apply Edits'><br>
					<br><input type='submit' name='cancel' value='Cancel'>
				</form>
	";


	Footer();
