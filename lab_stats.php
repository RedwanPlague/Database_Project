<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: logout.php");
    }

    require "connection.php";
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                $id = $_SESSION["id"];
                $query = pg_query($db, "SELECT * FROM labs WHERE lab_id = $id");
                $row = pg_fetch_row($query);

                echo "lab statistics: ".$row[1];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="lab_stats.php">
            <br/>

            <p>
                <input type="button" onclick="window.location = 'back_to_home.php';" name="home" value="home"/>
                <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/>
            </p>
        </form>
    </body>
</html>


<?php
    pg_close($db)
?>