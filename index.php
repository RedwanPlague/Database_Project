<?php
    session_start();
    require "connection.php";

    if(isset($_GET["email"]) && isset($_GET["password"])) {
        $email = $_GET["email"];
        $password = $_GET["password"];

        $selectOption = $_GET["role"];

        if($db) {
            if($selectOption == "patient") {
                $query = pg_query($db, "select * from patients");
            } else if($selectOption == "lab admin") {
                $query = pg_query($db, "select * from labs");
            } else if($selectOption == "collector") {
                $query = pg_query($db, "select * from collectors");
            } else if($selectOption == "doctor") {
                $query = pg_query($db, "select * from doctors");
            } else {
                /* problem */
            }

            $id = -1;
            $found = false;

            while($found != true && $row = pg_fetch_row($query)) {
                if(($selectOption == "patient" || $selectOption == "lab admin") && $email == $row[2] && password_verify($password, $row[5])) {
                    $id = $row[0];
                    $found = true;
                }

                if(($selectOption == "doctor") && $email == $row[2] && password_verify($password, $row[4])) {
                    $id = $row[0];
                    $found = true;
                }

                if(($selectOption == "collector") && $email == $row[3] && password_verify($password, $row[5])) {
                    $id = $row[0];
                    $found = true;
                }
            }

            pg_close($db);

            if($found == true) {
                if($selectOption == "patient") {
                    $_SESSION["id"] = $id;
                    $_SESSION["role"] = "patient";
                    $_SESSION["logged_in"] = set;

                    header('Location: patient_page.php');  // "Location: " is required
                    exit;
                } else if($selectOption == "lab admin") {
                    $_SESSION["id"] = $id;
                    $_SESSION["role"] = "lab admin";
                    $_SESSION["logged_in"] = set;

                    header('Location: lab_admin_page.php');  // "Location: " is required
                    exit;
                } else if($selectOption == "collector") {
                    $_SESSION["id"] = $id;
                    $_SESSION["role"] = "collector";
                    $_SESSION["logged_in"] = set;

                    header('Location: collector_page.php');  // "Location: " is required
                    exit;
                } else if($selectOption == "doctor") {
                    $_SESSION["id"] = $id;
                    $_SESSION["role"] = "doctor";
                    $_SESSION["logged_in"] = set;

                    header('Location: doctor_page.php');  // "Location: " is required
                    exit;
                } else {
                    // nothing
                }

            }

            if($found == false) {
                header('Location: login_fail.php');  // "Location: " is required
                exit;
            }
        }
    }?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title> welcome ! </title>
    </head>

    <!-- NOTICE below -->
    <body>
        <form name="form" action="index.php" method="get" onsubmit="return validate()">
            <p> <strong> <label for="email"> email: </label> </strong> <input id="email" type="text" name="email"/> </p>
            <p> <strong> <label for="password"> password: </label> </strong> <input id="password" type="password" name="password"/> </p>

            <p>
                <strong> login as: </strong> <br/>
                <strong> <label for="patient"> patient: </label> </strong> <input id="patient" type="radio" name="role" value="patient"/> <br/>
                <strong> <label for="lab admin"> lab admin: </label> </strong> <input id="lab admin" type="radio" name="role" value="lab admin"/> <br/>
                <strong> <label for="collector"> collector: </label> </strong> <input id="collector" type="radio" name="role" value="collector"/> <br/>
                <strong> <label for="doctor"> doctor: </label> </strong> <input id="doctor" type="radio" name="role" value="doctor"/>
            </p>

            <p> <input type="submit" name="submit" value="log in"> </p>

            <p> <input type="button" onclick="window.location = 'create_account.php';" name="create_account" value="create account"/> </p>
            <p> <input type="button" onclick="window.location = 'credit.php';" name="credit" value="credits"/> </p>

        </form>

        <script language="javascript" type="text/javascript">
            function validate() {
                var email = document.forms["form"]["email"].value;
                var password = document.forms["form"]["password"].value;

                var radios = document.getElementsByName("role");
                var formValid = false;

                var i = 0;

                while(formValid==false && i<radios.length) {
                    if(radios[i].checked == true) {
                        formValid = true;
                    }

                    i++;
                }

                if(formValid == false) {
                    alert("Must check some option!");
                    return false;
                }

                if(email == "") {
                    alert("email can not be empty");
                    return false;
                } else if(password == "") {
                    alert("password can not be empty");
                    return false;
                } else {
                    // nothing
                }

                return true;
            }
        </script>
    </body>
</html>
