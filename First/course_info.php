<?php
	session_start();

	$conn = pg_connect("host='localhost' port='5432' dbname='mydb' user='postgres' password='red'");
	if (!$conn) {
		echo 'An error occurred';
		exit;
	}

	if(isset($_GET['course'])) {
		$course_title = $_GET['course'];
	} else {
		$course_title = 'All Course Information';
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>
		<?php echo $course_title; ?>
	</title>
	<style type="text/css">
		ul { font-size: 20px; }
		#home { font-size: 30px; }
	</style>
</head>
<body>

<?php

	if(isset($_GET['course'])) {

		$result = pg_query($conn, "SELECT name FROM courses WHERE title = '$course_title'");
		$row = pg_fetch_array($result);
		echo "<h1>$course_title - $row[0]</h1>";

		$result = pg_query($conn, "SELECT id, name FROM teachers WHERE id IN (SELECT teacher_id FROM instructors WHERE course_title = '$course_title')");
		if (!$result) {
			echo 'An error occurred';
			exit;
		}
		
		echo '<p><h2>Teachers of this course:</h2>';
		echo '<ul>';
		while ($row = pg_fetch_row($result)) {
			echo "<li><a href='javascript: submitTch($row[0])'>$row[1]</a></li>";
		}
		echo "</ul></p><br>\n";
	}
	else {
		$result = pg_query($conn, "SELECT title, name FROM courses");
		if (!$result) {
			echo 'An error occurred';
			exit;
		}

		echo '<p><h2>All Courses:</h2>';
		echo '<ul>';
		while ($row = pg_fetch_row($result)) {
			echo "<li><a href='javascript: submitCrs(\"".$row[0]."\")'>$row[0]</a> - $row[1]</li>";
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