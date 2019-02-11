<?php
    $host = "host = localhost";
    $port = "port = 5432";
    $dbname = "dbname = projdb";
    $user_info = "user = postgres password='red'";

    $db = pg_connect("$host $port $dbname $user_info");