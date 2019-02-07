<?php
	session_start();

	if(isset($_SESSION['name'])) {
		$username = $_SESSION['username'];
		$name = $_SESSION['name'];
	} else {
		$name = 'Information';
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>
		<?php echo $name; ?>
	</title>
	<style type="text/css">
		#logout { font-size: 30px; }
		ul { font-size: 20px; }
	</style>
</head>
<body>

<?php

	if(!isset($_SESSION['name'])) {
		echo 'You must log in first!<br> log in from <a href="login.php">here</a>';
		exit;
	}

	echo "<h1> Welcome $name </h1>";

	$conn = pg_connect("host='localhost' port='5432' dbname='mydb' user='postgres' password='red'");
	if (!$conn) {
		echo 'An error occurred';
		exit;
	}

	$result = pg_query($conn, "SELECT id, name FROM teachers WHERE id = (SELECT adviser FROM students WHERE id = $username)");
	if (!$result) {
		echo 'An error occurred';
		exit;
	}

	echo '<p><h2>My Adviser:</h2>';
	echo '<ul>';
	$row = pg_fetch_array($result);
	echo "<li><a href='javascript: submitTch(".$row[0].")'>$row[1]</a></li></ul></p><br>\n";

	$result = pg_query($conn, "SELECT title, name FROM courses WHERE title IN (SELECT course_title FROM registrations WHERE student_id = $username)");
	if (!$result) {
		echo 'An error occurred';
		exit;
	}

	echo '<p><h2>My courses:</h2>';
	echo '<ul>';
	while ($row = pg_fetch_row($result)) {
		echo "<li><a href='javascript: submitCrs(\"".$row[0]."\")'>$row[0]</a> - $row[1]</li>";
	}
	echo "</ul></p><br>\n";

	pg_close($conn);

?>

<a id="logout" href="logout.php">Log Out</a>
<form name="cinfo" action="course_info.php" method="GET">
	<input name="course" hidden type="text">
</form>

<form name="tinfo" action="teacher_info.php" method="GET">
	<input name="teacher" hidden type="text">
</form> 

<script type="text/javascript">
	function submitCrs(courseTitle) {
		document.cinfo['course'].value = courseTitle;
		document.cinfo.submit();
	}
	function submitTch(tchId) {
		document.tinfo['teacher'].value = tchId;
		document.tinfo.submit();
	}
</script>

</body>
</html>