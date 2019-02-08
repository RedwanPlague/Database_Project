<?php
    require "connection.php";

    if(isset($_GET["name"]) && isset($_GET["email"]) && isset($_GET["phone"]) && isset($_GET["password"]) && isset($_GET["confirm_password"])) {
        /* MAY BE, PROCEDURE WILL BE ADDED HERE LATER */

        $name = $_GET["name"];
        $email = $_GET["email"];
        $phone = $_GET["phone"];
        $password = $_GET["password"];
        //$password = md5($_GET["password"]);  // NOTICE: IMPORTANT
        $location_id = $_GET["location"];

        $query = pg_query($db, "SELECT email FROM patients");
        $matched = false;

        /* NOTICE */
        while($matched == false && $row = pg_fetch_row($query)) {
            if($_GET["email"] == $row[0]) {
                $matched = true;
            }
        }

        if($matched == false) {
            pg_query($db, "INSERT INTO patients(name, email, phone_no, location_id, password) VALUES ('$name', '$email', $phone, $location_id, '$password')");

            $row = pg_fetch_row(pg_query($db, "SELECT patient_id FROM patients WHERE email = $email"));
            $id = $row[0];

            $_SESSION["id"] = $id;
            $_SESSION["role"] = "patient";
            $_SESSION["logged_in"] = true;

            header('Location: patient_page.php');  // "Location: " is required
            exit;
        }

        if($matched == true) {
            echo "<strong> account not created: same email address already exists </strong>";
        }
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title> create patient account </title>
    </head>

    <body>
        <form name="form" action="create_patient.php" method="get" onsubmit="return validate()">
            <p> <strong> <label for="name"> name: </label> </strong> <input id="name" type="text" name="name"/> </p>
            <p> <strong> <label for="email"> email: </label> </strong> <input id="email" type="text" name="email"/> </p>
            <p> <strong> <label for="phone"> phone: </label> </strong> <input id="phone" type="text" name="phone"/> </p>
            <p> <strong> <label for="password"> password: </label> </strong> <input id="password" type="password" name="password"/> </p>
            <p> <strong> <label for="confirm_password"> confirm password: </label> </strong> <input id="confirm_password" type="password" name="confirm_password"/> </p>

            <p>
                <strong> choose location: </strong> <br/>

                <?php
                    $query = pg_query($db, "SELECT * FROM locations");

                    while($row = pg_fetch_row($query)) {
                        echo "<strong> <label for=\"".$row[1]."\">".$row[1]."</label> </strong> <input id=\"".$row[1]."\" type=\"radio\" name=\"location\" value=\"".$row[0]."\"/> <br/>";
                    }
                ?>
            </p>

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

                var radios = document.getElementsByName("location");
                var formValid = false;

                var i = 0;

                while(formValid===false && i<radios.length) {
                    if(radios[i].checked === true) {
                        formValid = true;
                    }

                    i++;
                }

                if(formValid === false) {
                    alert("Must check some option!");
                    return false;
                }

                if(name === "") {
                    alert("name can not be empty");
                    return false;
                } else if(email === "") {
                    alert("email can not be empty");
                    return false;
                } else if(phone === "") {
                    alert("phone number can not be empty");
                    return false;
                } else if(password === "" || confirm_password === "") {
                    alert("password can not be empty");
                    return false;
                } else if(password !== confirm_password) {
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
