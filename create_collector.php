<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: logout.php");
    }

    require 'connection.php';

    if(isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["phone"]) && isset($_GET["password"]) && isset($_GET["confirm_password"])) {
        /* MAY BE, PROCEDURE WILL BE ADDED HERE LATER */

        $name = $_GET["name"];
        $email = $_GET["email"];
        $phone = $_GET["phone"];
        $password = $_GET["password"];
        //$password = md5($_GET["password"]);  // NOTICE: IMPORTANT

        $query = pg_query($db, "SELECT * FROM collectors");
        $matched = false;

        /* NOTICE */
        while($matched == false && $row = pg_fetch_row($query)) {
            if($_GET["email"] == $row[3]) {
                $matched = true;
            }
        }

        if($matched == false) {
            $id = $_SESSION["id"];
            pg_query($db, "INSERT INTO collectors(lab_id, name, email, phone_no, password) VALUES ($id, $name, $email, $phone, $password)");
        }

        if($matched == true) {
            echo "<strong> account not created: same email address already exists </strong>";
        }
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title> create collector account </title>
    </head>

    <body>
        <form name="form" action="create_collector.php" method="get" onsubmit="return validate()">
            <p> <strong> <label for="name"> name: </label> </strong> <input id="name" type="text" name="name"/> </p>
            <p> <strong> <label for="email"> email: </label> </strong> <input id="email" type="text" name="email"/> </p>
            <p> <strong> <label for="phone"> phone: </label> </strong> <input id="phone" type="text" name="phone"/> </p>
            <p> <strong> <label for="password"> password: </label> </strong> <input id="password" type="password" name="password"/> </p>
            <p> <strong> <label for="confirm_password"> confirm password: </label> </strong> <input id="confirm_password" type="password" name="confirm_password"/> </p>

            <p>
                <input type="submit" name="submit" value="create">
            </p>
        </form>

        <script language="javascript" type="text/javascript">
            function validate() {
                var name = document.forms["form"]["name"].value;
                var email = document.forms["form"]["email"].value;
                var phone = document.forms["form"]["phone"].value;
                var password = document.forms["form"]["password"].value;
                var confirm_password = document.forms["form"]["confirm_password"].value;

                if(name == "") {
                    alert("name can not be empty");
                    return false;
                } else if(email == "") {
                    alert("email can not be empty");
                    return false;
                } else if(phone == "") {
                    alert("phone number can not be empty");
                    return false;
                } else if(password == "" || confirm_password == "") {
                    alert("password can not be empty");
                    return false;
                } else if(password != confirm_password) {
                    alert("password mismatched");
                    return false;
                } else {
                    // nothing
                }

                return true;
            }
        </script>
    </body>
</html>

<?php
    pg_close($db);
?>