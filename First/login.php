<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Log In</title>
	<style type="text/css">
		body { font: bold 20px Tahoma; }
		input { font: bold 15px Tahoma; }
		#msg { color: red; font: 18px Arial; }
	</style>
</head>
<body>

<?php

	if(isset($_POST['username']) && isset($_POST['password'])) {

		$conn = pg_connect("host='localhost' port='5432' dbname='mydb' user='postgres' password='red'");
		if (!$conn) {
			echo 'An error occurred';
			exit;
		}

		$result = pg_query($conn, "SELECT id, password, name FROM students");
		if (!$result) {
			echo 'An error occurred';
			exit;
		}

		$username = $_POST['username'];
		$password = $_POST['password'];
		$found = false;
		while ($row = pg_fetch_row($result)) {
			if($row[0] == $username && $row[1] == $password) {
				$found = true;
				$name = $row[2];
				break;
			}
		}
		if($found) {
			$_SESSION['username'] = $username;
			$_SESSION['name'] = $name;
			header('Location: student_home.php');
		} else {
			echo 'Sorry! could not log you in.';
		}

		pg_close($conn);
	}

?>

<hr>
<form name="first" method="POST" action="login.php" onsubmit="return validate()">
	Username: <input type="text" name="username" /> 
	Password: <input type="password" name="password" /> 
	<input type="submit" value="Log In" />
</form>
<p id="msg"></p>

<script type="text/javascript">
	function validate() {
		var username = document.forms['first']['username'].value;
		var password = document.forms['first']['password'].value;
		if(username === "") {
			document.getElementById('msg').innerHTML = 'Username cannot be empty';
			return false;
		}
		else if(password === "") {
			document.getElementById('msg').innerHTML = 'Password cannot be empty';
			return false;
		}
		return true;
	}
</script>

</body>
</html>