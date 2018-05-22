<!-- write an array variable of weather conditions with the following values: rain, sunshine, clouds, hail, sleet, snow, wind.
Using the array variable for all the weather conditions, echo the following statement to the browser:

We've seen all kinds of weather this month. At the beginning of the month, we had snow and wind.
Then came sunshine with a few clouds and some rain. At least we didn't get any hail or sleet. -->
<?php
	$weather = array("rain", "sunshine", "clouds", "hail", "sleet", "snow", "wind");

	echo"
		We've seen all kinds of weather this month. At the beginning of the month, we had $weather[5] and $weather[6].
		Then came $weather[1] with a few $weather[2] and some $weather[0]. At least we didn't get any $weather[3] or $weather[4].
	";

?>
