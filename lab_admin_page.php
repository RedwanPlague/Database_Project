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

                echo $row[1];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="lab_admin_page.php">
            <p> <input type="button" onclick="window.location = 'create_collector.php';" name="create_collector" value="create collector"/> </p>
            <p> <input type="button" onclick="window.location = 'collector_info.php';" name="collector_info" value="collector info"/> </p>
            <p> <input type="button" onclick="window.location = 'sample_info.php';" name="sample_info" value="sample info"/> </p>
            <p> <input type="button" onclick="window.location = 'lab_stats.php';" name="lab_stats" value="lab statistics"/> </p>
            <br/>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>
    </body>
</html>

<?php
    pg_close($db)
?>