<?php

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "collector" || !isset($_GET['dig']) || !isset($_GET['test'])) {
        header("Location: back_to_home.php");
    }

    require 'connection.php';

    $collector_id = $_SESSION['id'];
    $diagnosis_id = $_GET['dig'];
    $test_id = $_GET['test'];

    $query = pg_fetch_row(pg_query("SELECT D.collector_id FROM diagnosis D WHERE D.diagnosis_id = $diagnosis_id"));

    if($query[0] != $collector_id) {
        header("Location: back_to_home.php");
    }

    pg_query("UPDATE samples SET collected = true WHERE diagnosis_id = $diagnosis_id AND test_id = $test_id");

    pg_close($db);

    header('Location: collector_page.php');
?>