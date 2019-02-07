<?php
	session_start();

	$conn = pg_connect("host='localhost' port='5432' dbname='mydb' user='postgres' password='red'");
	if (!$conn) {
		echo 'An error occurred';
		exit;
	}

	if(isset($_GET['teacher'])) {
		$tch_id = $_GET['teacher'];

		$result = pg_query($conn, "SELECT name FROM teachers WHERE id = $tch_id");
		$row = pg_fetch_array($result);
		$name = $row[0];
	}
	else {
		$name = "All Teacher's Information";
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php echo $name; ?>
	</title>
	<style type="text/css">
		ul { font-size: 20px; }
		#home { font-size: 30px; }
	</style>
</head>
<body>

<?php

	if(isset($_GET['teacher'])) {
		echo "<h1>$name</h1>";

		$result = pg_query($conn, "SELECT title, name FROM courses WHERE title IN (SELECT course_title FROM instructors WHERE teacher_id = $tch_id)");
		if (!$result) {
			echo 'An error occurred';
			exit;
		}
		
		echo '<p><h2>Instructor of courses:</h2>';
		echo '<ul>';
		while ($row = pg_fetch_row($result)) {
			echo "<li><a href='javascript: submitCrs(\"".$row[0]."\")'>$row[0]</a> - $row[1]</li>";
		}
		echo "</ul></p><br>\n";
	}
	else {
		$result = pg_query($conn, "SELECT id, name FROM teachers");
		if (!$result) {
			echo 'An error occurred';
			exit;
		}

		echo '<p><h2>All Teachers:</h2>';
		echo '<ul>';
		while ($row = pg_fetch_row($result)) {
			echo "<li><a href='javascript: submitTch($row[0])'>$row[1]</a></li>";
		}
		echo "</ul></p><br>\n";
	}
	
	pg_close($conn);

?>

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

<a id="home" href="student_home.php">Home</a>

</body>
</html>