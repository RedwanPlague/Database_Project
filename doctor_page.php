<?php
    session_start();
    require "connection.php";

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "doctor") {
        header("Location: logout.php");
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                $id = $_SESSION["id"];
                $query = pg_query($db, "SELECT * FROM doctors WHERE doctor_id = $id");
                $row = pg_fetch_row($query);

                echo $row[1];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="doctor_page.php">
            <!-- <p> <input type="button" onclick="window.location = 'lab_info.php';" name="visitLab" value="visit lab"/> </p>
            <p> <input type="button" onclick="window.location = 'test_info.php';" name="knowTest" value="know test"/> </p>
            <p> <input type="button" onclick="window.location = 'testBook.php';" name="bookTest" value="book test"/> </p> -->

            <br/>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>
    </body>
</html>

<?php
    pg_close($db)
?>