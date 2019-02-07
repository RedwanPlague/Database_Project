<?php 

class DBconnection
{
	var $connect;

	function DBconnection()
	{
		$this->connect = pg_connect("host='localhost' port='5432' dbname='mydb' user='postgres' password='red'") or die("unable to connect to database");
	}
}

?>