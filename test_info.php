<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    $add = '';
    if(isset($_GET['id']))
        $add = '?id='.$_GET['id'];

    if($_SESSION['role'] == 'lab admin' || $_SESSION['role'] == 'collector') {
        header('Location: lab_test_info.php'.$add);
    }
    else if($_SESSION['role'] == 'patient') {
        header('Location: patient_test_info.php'.$add);
    }

?>
