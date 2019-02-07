<?php

$host = "host = localhost";
$port = "port = 5432";
$dbname = "dbname = projdb";
$user_info = "user = postgres password = '123456789'";

$db = pg_connect("$host $port $dbname $user_info");

