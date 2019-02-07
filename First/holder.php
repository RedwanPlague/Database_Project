<?php

	$conn = pg_connect("host='localhost' port='5432' dbname='mydb' user='postgres' password='red'");
	if (!$conn) {
		echo 'An error occurred';
		exit;
	}
	//pg_close($conn);

?>