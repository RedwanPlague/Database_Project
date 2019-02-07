<?php
    if(isset($_GET["role"]) == true) {
        $selectOption = $_GET["role"];

        if($selectOption == "patient") {
            header("Location: create_patient.php");
            exit;
        } else if($selectOption == "lab admin") {
            header("Location: create_lab.php");
            exit;
        } else if($selectOption == "doctor") {
            header("Location: create_doctor.php");
            exit;
        } else if($selectOption == "collector") {
            header("Location: create_collector.php");
            exit;
        } else {

        }
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title> create account </title>
    </head>

    <body>
        <form name="form" action="create_account.php" method="get" onsubmit="return validate()">
            <p>
                <strong> create account as: </strong> <br/>
                <strong> <label for="patient"> patient: </label> </strong> <input id="patient" type="radio" name="role" value="patient"/> <br/>
                <strong> <label for="lab admin"> lab admin: </label> </strong> <input id="lab admin" type="radio" name="role" value="lab admin"/> <br/>
                <strong> <label for="collector"> collector: </label> </strong> <input id="collector" type="radio" name="role" value="collector"/> <br/>
                <strong> <label for="doctor"> doctor: </label> </strong> <input id="doctor" type="radio" name="role" value="doctor"/>
            </p>


            <p>
                <input type="submit" name="submit" value="submit">
            </p>
        </form>

        <script language="javascript" type="text/javascript">
            function validate() {
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

                return true;
            }
        </script>
    </body>
</html>

