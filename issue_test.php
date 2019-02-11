<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION['role'] != "doctor" || !isset($_GET['patient']) || !isset($_GET['test'])) {
        header("Location: back_to_home.php");
    }

    require 'connection.php';

    $doctor_id = $_SESSION['id'];
    $patient_id = $_GET['patient'];
    $test_id = $_GET['test'];
    $result = pg_query($db,"CALL issue_test($doctor_id,$patient_id,$test_id)");

    pg_close($db);

    header('Location: doctor_page.php');
?>