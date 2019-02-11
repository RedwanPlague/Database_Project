<?php
    session_start();
    require "connection.php";

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: back_to_home.php");
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                $id = $_SESSION["id"];
                $query = pg_query($db, "SELECT name FROM labs WHERE lab_id = $id");
                $row = pg_fetch_row($query);

                echo $row[0];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="lab_admin_page.php">
            <p> <input type="button" onclick="window.location = 'create_collector.php';" name="create_collector" value="create collector"/> </p>
            <p> <input type="button" onclick="window.location = 'collector_info.php';" name="collectorInfo" value="collector info"/> </p>
            <p> <input type="button" onclick="window.location = 'sample_info.php';" name="sampleInfo" value="sample info"/> </p>
            <p> <input type="button" onclick="window.location = 'test_info.php';" name="testInfo" value="test info"/> </p>
            <br/>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>
    </body>
</html>

<?php
    pg_close($db)
?>