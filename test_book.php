<?php
    session_start();
    require "connection.php";

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "patient") {
        header("Location: logout.php");
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title> test booking </title>
    </head>

    <body>
        <strong> hello ! </strong>

        <form name="form" action="test_book.php">
            <br/>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>
    </body>
</html>

<?php
    pg_close($db)
?>