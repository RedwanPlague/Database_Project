<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
</head>
<body>

<?php

	for ($i = 0; $i < 10; $i++) 
	{ 
		$s = "th";
		if($i == 1)
			$s = "st";
		else if($i == 2)
			$s = "nd";
		else if($i == 3)
			$s = "rd";
		echo "<marquee> This is the $i$s moving block </marquee>";
	}

?>

</body>
</html>