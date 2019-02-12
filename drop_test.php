<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin" || !isset($_GET['id'])) {
        header("Location: back_to_home.php");
    }

    require 'connection.php';

    $lab_id = $_SESSION['id'];
    $test_id = $_GET['id'];

    pg_query("DELETE FROM offers WHERE lab_id = $lab_id AND test_id = $test_id");

    header('Location: test_info.php');

?>
