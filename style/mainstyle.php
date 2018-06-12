<?php
echo"
	:root{
		--picColor: #F1D5B5;				/*pale orange yellow*/
		--blogColor: #D0D7E2;				/*pale blue*/
		--thirdColor: #F6F5F2;				/*light light grey*/
		--fourthColor: #ADA9B0;				/*darker grey*/
		--buttonBorderColor: #707889;		/*dark blue grey*/
		--buttonColor: #D3DAE5;				/*pale blue*/
		--seventhColor:#D4AB81;				/*dark orange*/
		--userColor: #CBCBD3;				/*grey*/
	}

	img{
		max-height: 900px;
		max-width: 1500px;
		border: white, 1px;
	}

	body{
		text-align:center;
		/* background-image: url('/pictures/fcfbfa-ugur-akdemir-283278-unsplash.jpg'); */
		background-color: #fff;
		font-family:monospace;
	}

	a:link{
		color: blue;
	}

	a:visited{
		color: grey;
	}

	a:hover{
		color: lightblue;
	}

	a:active{
		color: purple;
	}

	h1{
		padding: 2em;
		background-image: url('/pictures/f7f6f5-anastasia-taioglou-347661-unsplash.jpg');
		background-color: #eee;
		background-repeat: no-repeat;
	    background-attachment:local;
		/* background-size: contain; */
	    background-position: center 60%;
	}

	h2{
		text-decoration:underline;
	}

	.required{
		color: red;
	}

	.home{
		bottom:0%;
		position:fixed;
	}

	/* CONTAINERS */

	.container1{
		border-radius: 25px;
	    background: var(--blogColor);
	    padding: 20px;
		width: 40%;
		/* float: left; */
		display: table-cell;
	}

	.container2{
		border-radius: 25px;
	    background: #F6F5F2;
		padding: 20px;
		width: 20%;
		/* float: left; */
		display: table-cell;
	}

	.container3{
		border-radius: 25px;
	    background: var(--picColor);
	    padding: 20px;
		position: middle right;
		width: 40%;
		/* float: right; */
		display: table-cell;
	}

	.usercontainer{
		border-radius: 25px;
	    background: var(--userColor);
	    padding: 20px;
		width: 40%;
		margin:auto;
	}

	.maincontainer{
		display: table;
	    width: 100%;
		border-spacing: 4px;
	}

	.postcontainerB{
		border-radius: 25px;
	    background: var(--blogColor);
	    padding: 20px;
		width: 60%;
		margin:auto;
	}

	.postcontainerP{
		border-radius: 25px;
	    background: var(--picColor);
	    padding: 20px;
		width: 60%;
		margin:auto;
	}

	#tag{
		padding: 2px;
		border-style:solid;
		border-width: 1px;
		border-color: #00f;
		background: #5d90e0;
		color: white;
	}

	a.tag{
		color: white;
	}

	.close{
		color: white;
		text-decoration:none;
	}

	.comment{
		padding:1em;
		background-color:#eee;
		border-radius: 3px;
	}

	.userbadge{
		padding:2px;
		font-weight:bold;
		background-color:#ddd;
		color:#fff;
	}

	/* flavortext information pop up */
	.flavorInfo{
		padding:1em;
		background-color:#ddd;
		color:#222;
		display:none;
		border-radius: 25px;
	}

	.flavorInfoQM{
		padding:2px;
		background-color:#ddd;
		color:#25e;
	}

	/* Buttons */
	input[type='submit'], button{
		background-color: var(--buttonColor);
		border-radius: 8px;
		border-color: var(--buttonBorderColor);
	}
";
