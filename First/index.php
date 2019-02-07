<?php

	//session_start();

	//print_r($_SESSION);
	print_r($_POST);

?>

<!DOCTYPE html>
<html>
<head>
	<title>INDEZ</title>
</head>
<body>

	<hr>
	<form name="first" action="index.php" method="post" onsubmit="return validate()">
		Day:<br><input type="text" name="day"><br>
		Year:<br><input type="text" name="year"><br>
		Password:<br><input type="password" name="password"><br>
		<input type="submit" value="Submit">
	</form>

	<p id="msg"></p>

	<!-- <a href="info.php">Back</a> -->

	<script type="text/javascript">
		function validate() {
			var day = document.forms["first"]["day"].value;
			var year = document.forms["first"]["year"].value;
			var password = document.forms["first"]["password"].value;
			if(day == "") {
				document.getElementById('msg').innerHTML = 'Day cannot be empty';
				return false;
			}
			else if(year == "") {
				document.getElementById('msg').innerHTML = 'Year cannot be empty';
				return false;
			}
			else if(password == "") {
				document.getElementById('msg').innerHTML = 'Password cannot be empty';
				return false;
			}
			document.getElementById('msg').innerHTML = 'Okay';
			return true;
		}
	</script>


</body>
</html>
