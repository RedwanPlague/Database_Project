<?php
    session_start();
    require "connection.php";

    if(isset($_GET["email"]) && isset($_GET["password"])) {
        $email = $_GET["email"];
        $password = $_GET["password"];

        $selectOption = $_GET["role"];

        if($db) {
            if($selectOption == "patient") {
                $query = pg_query($db, "select patient_id, email, password from patients");
            } else if($selectOption == "lab admin") {
                $query = pg_query($db, "select lab_id, email, password from labs");
            } else if($selectOption == "collector") {
                $query = pg_query($db, "select collector_id, email, password from collectors");
            } else if($selectOption == "doctor") {
                $query = pg_query($db, "select doctor_id, email, password from doctors");
            }

            $id = -1;
            $found = false;

            while($found != true && $row = pg_fetch_row($query)) {
                if($email == $row[1] && $password == $row[2]) {
                    $id = $row[0];
                    $found = true;
                }
            }

            pg_close($db);

            if($found == true) {
                $_SESSION["id"] = $id;
                $_SESSION["role"] = $selectOption;
                $_SESSION["logged_in"] = true;
                header("Location: back_to_home.php");
                exit;
            }

            if($found == false) {
                header('Location: login_fail.php');  // "Location: " is required
                exit;
            }
        }
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title> welcome ! </title>
    </head>

    <body>
        <form name="form" action="index.php" method="get" onsubmit="return validate()">
            <p>
                <strong> <label for="email"> email: </label> </strong> <input id="email" type="text" name="email"/>
                <strong> <label for="password"> password: </label> </strong> <input id="password" type="password" name="password"/>
            </p>

            <p>
                <strong> login as: </strong> <br/>
                <strong> <label for="patient"> patient: </label> </strong> <input id="patient" type="radio" name="role" value="patient"/> <br/>
                <strong> <label for="lab admin"> lab admin: </label> </strong> <input id="lab admin" type="radio" name="role" value="lab admin"/> <br/>
                <strong> <label for="collector"> collector: </label> </strong> <input id="collector" type="radio" name="role" value="collector"/> <br/>
                <strong> <label for="doctor"> doctor: </label> </strong> <input id="doctor" type="radio" name="role" value="doctor"/>
            </p>


            <p>
                <input type="submit" name="submit" value="log in">
                <input type="button" onclick="window.location = 'create_account.php';" name="create_account" value="create account"/>
            </p>
        </form>

        <script language="javascript" type="text/javascript">
            function validate() {
                var email = document.forms["form"]["email"].value;
                var password = document.forms["form"]["password"].value;

                var radios = document.getElementsByName("role");
                var formValid = false;

                var i = 0;

                while(!formValid && i<radios.length) {
                    if(radios[i].checked) {
                        formValid = true;
                    }

                    i++;
                }

                if(!formValid) {
                    alert("Must check some option!");
                    return false;
                }

                if(email === "") {
                    alert("email can not be empty");
                    return false;
                } else if(password === "") {
                    alert("password can not be empty");
                    return false;
                }

                return true;
            }
        </script>
    </body>
</html>
