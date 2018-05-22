<?php
	function printArray($array){
		for($i=0; $i<count($array);$i++){
			if ($i!=count($array)-1){
				echo"
					$array[$i],
				";
			}
			else{
				echo"
					$array[$i]
				";
			}
		}
	}

	function printArrayList($array){
		echo"<ul>";
		for($i=0; $i<count($array);$i++){
			if ($i!=count($array)-1){
				echo"<li>$array[$i]</li>";
			}
		}
		echo"</ul>";
	}


	$city = array("Tokyo", "Mexico City", "New York City", "Mumbai", "Seoul", "Shanghai", "Lagos", "Buenos Aires", "Cairo", "London", "Los Angeles", "Calcutta", "Osaka", "Beijing");

	printArray($city);
	sort($city);
	echo"<br><br>Sorted, unordered list:";
	printArrayList($city);

?>
