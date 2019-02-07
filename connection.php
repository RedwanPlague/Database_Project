<?php
    $host = "host = localhost";
    $port = "port = 5432";
    $dbname = "dbname = HIV_Aladeen";
    $credentials = "user = postgres password = 19yasar95";

    $db = pg_connect("$host $port $dbname $credentials");
?>