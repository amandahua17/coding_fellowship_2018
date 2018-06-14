<?php
	include('include/include_all.php');

	$type=$_REQUEST['type'];
	$h1array['pic'] = ' Picture ';
	$h1array['blog'] = ' Blog ';
	$containerarray['pic'] = "<div class= 'postcontainerP'>";
	$containerarray['blog'] = "<div class= 'postcontainerB'>";

	$errors = array();

	// $tagarray=array();
	// var_dump($_REQUEST);

	// if(isset($_REQUEST['tagsub'])){
	// 	$_REQUEST['tagString'].=",";
	// 	$_REQUEST['tagString'].=$_REQUEST['tags'];
	// 	// var_dump($_REQUEST, $tagarray);
	// 	echo"tag added!";
	// }

	if(isset($_REQUEST['tagString'])){
		$tagarray = explode(',', $_REQUEST['tagString']);
	}else{
		$tagarray = array();
	}
	if(isset($_REQUEST['button'])){
		if($type == 'blog'){
			$errors+=ValidateTextField('Title', $errors);
			$errors+=ValidateTextField('Body', $errors);
			if(sizeof($errors)==0){
				InsertBlogPost($_REQUEST['Author'], $_REQUEST['Title'], $_REQUEST['Body'], $tagarray);
				header('Location: index.php');
				exit();
			}
		}else if($type == 'pic'){
			$errors+=ValidateTextField('Photographer', $errors);
			$errors+=ValidateTextField('Title', $errors);
			$errors+=ValidateTextField('Link', $errors);
			if(sizeof($errors) == 0){
				InsertPic($_REQUEST['Photographer'], $_REQUEST['Title'], $_REQUEST['Body'], $_REQUEST['Link'], $_REQUEST['Flavortext'], $tagarray);
				header('Location: index.php');
				exit();
			}
		}
	}

	Heading("Create Post", "");


	// ShowLoginPage();
	// ShowCreateAccountPage();
	echo"
				<h1>Create Your Own";

	TypeBasedEcho($type, $h1array);
	echo							"Post</h1>";

	TypeBasedEcho($type, $containerarray);
	foreach($errors as $key=>$val){
		echo"<span style='color: red'>$key is a required field!<br></span>";
	}

	echo"
				<br><form method='post' name='form'>";
				if($type== 'pic'){
					ShowTextField(true, 'Photographer', '');
					ShowTextField(true, 'Title', '');
					ShowTextField(false, 'Body', '');
					ShowTextField(true, 'Link', '');
					ShowTextField(false, 'Flavortext', '');
					echo"<p>What is flavor text?  <span class='flavorInfoQM' onmouseover='FlavorFadeIn()' onmouseout='FlavorFadeOut()'>?</span></p>";
					ShowFlavorInfo();


				}else if($type=='blog'){
					ShowTextField(false, 'Author', '');
					ShowTextField(true, 'Title', '');
					ShowTextField(true, 'Body', '');
				}
				ShowTagField();
				ShowHiddenField('tagString', @$_REQUEST['tagString']);
				echo"<div id='tagSection'>Tags: ";
				foreach($tagarray as $tag){
					if(($tag!=NULL)&&($tag!=''))
					echo" #".$tag;
				}
				// var_dump(@$_REQUEST['tagString']);


	echo"		</div>
					<br><input type='submit' name = 'button'>
				</form>
			</div>";

	Footer();
