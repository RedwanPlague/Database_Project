<?php
    /*session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION['role'] != "patient") {
        header("Location: back_to_home.php");
    }

    require 'connection.php';

    $patient_id = $_SESSION['id'];
    $lab_id = $_GET['lab'];
    $test_id = $_GET['test'];

    pg_query("CALL book_test($patient_id, $lab_id, $test_id)");

    header('Location: patient_page.php');*/

?>