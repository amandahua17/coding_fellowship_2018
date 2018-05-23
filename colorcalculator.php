<?php
	function mixcolors($color1, $color2){
		$hex='000';
		$hex=hexdec($hex);
		$char0 = (hexdec(substr($color1, 0, 1))+hexdec(substr($color2, 0, 1)));
		$char1 = (hexdec(substr($color1, 1, 1))+hexdec(substr($color2, 1, 1)));
		$char2 = (hexdec(substr($color1, 2, 1))+hexdec(substr($color2, 2, 1)));
		if((stripos($color1, 'f'))&&(stripos($color2, 'f'))){
			$combined=(hexdec($color1))+(hexdec($color2));
			return dechex($combined);
		}
		if($char0>=15){
			$hex+=3840;

		}
		else{
			$hex+=($char0*pow(16,2));
		}
		if($char1>=15){
			$hex+=240;
		}
		else{
			$hex+=($char1*16);
		}
		if($char2>=15){
			$hex+=15;
		}
		else{
			$hex+=$char2;
		}
		return dechex($hex);
	}
	echo"
		<style>
		</style>
		<body>
			<h1 style='text-align: center; font-family: cursive;'>Color Calculator: Enter the two colors that you would like to mix.</h1>
			<h2 style='text-align: center; font-family: cursive;'>Due to the nature of hex colors, the color values will simply be added, therefore once an rgb value maxes out, it will not overflow.</h2>
			<h2 style='text-align: center; font-family: cursive;'>The background will change to match the mix.</h2>
			<form style='text-align: center;' action=''>
				<select name = 'color1'>
					<option value='f00'>red</option>
					<option value='0f0'>green</option>
					<option value='00f'>blue</option>
					<option value='000'>black</option>
					<option value='fff'>white</option>
					<option value='ff0'>yellow</option>
					<option value='f0f'>magenta</option>
					<option value='0ff'>aqua</option>
				</select>
				<select name = 'color2'>
					<option value='f00'>red</option>
					<option value='0f0'>green</option>
					<option value='00f'>blue</option>
					<option value='000'>black</option>
					<option value='fff'>white</option>
					<option value='ff0'>yellow</option>
					<option value='f0f'>magenta</option>
					<option value='0ff'>aqua</option>
				</select>
				<input type = 'submit' />
			</form>
		</body>
		";
		if(isset($_REQUEST['color1'])&&isset($_REQUEST['color2'])){
			$hex=mixcolors($_REQUEST['color1'], $_REQUEST['color2']);
			 $sub1='';
			 $sub2='';
			if(strlen($hex)<3){
				$sub1='0';
				if(strlen($hex)<2){
					$sub2='0';
				}
			}
			if(($hex == 'fff')||($hex == 'ff0')){
				$text = 'black';
			}else{

				$text = 'white';
			}
			echo "
				<style>
				body{
					background-color: #$sub1$sub2$hex;
					color: $text;
				}
				</style>
				<h2 style='text-align: center; font-family: cursive;'>You mixed $_REQUEST[color1] and $_REQUEST[color2], resulting in $hex.</h2>";
		}

?>
