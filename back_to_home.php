<?php
    session_start();

    if($_SESSION["role"] == "patient") {
        header("Location: patient_page.php");
    } else if($_SESSION["role"] == "lab admin") {
        header("Location: lab_admin_page.php");
    } else if($_SESSION["role"] == "collector") {
        header("Location: collector_page.php");
    } else if($_SESSION["role"] == "doctor") {
        header("Location: doctor_page.php");
    }
?>