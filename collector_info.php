<!-- created by Redwanul Haque -->

<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: logout.php");
    }

    require 'connection.php';

    if(!isset($_GET['id']))
        $all = true;
    else
        $all = false;

    if(!$all) {
        $collector_id = $_GET['id'];

        $collector_info = pg_fetch_row(pg_query($db, "SELECT * FROM collectors WHERE collector_id = $collector_id"));

        if(!$collector_info)
            header("Location: collector_info.php");
    }

    function print_collector($collector_row) {
        echo "<a href=\"collector_info.php?id=$collector_row[0]\">$collector_row[2]</a> ";

        for($i=3; $i<5; $i++) {
            echo "   $collector_row[$i]";
        }
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                if($all)
                    echo "Collector List";
                else
                    echo "$collector_info[2]";
            ?>
        </title>
    </head>

    <body>
        <?php
            if($all) {
                echo "<p> <h2> Collectors </h2> </p>";

                $id = $_SESSION["id"];
                $result = pg_query($db, "SELECT * FROM collectors WHERE lab_id = $id");

                while($row = pg_fetch_row($result)) {
                    echo "<p>".print_collector($row)."</p>";
                }
            } else {
                echo "<p>".print_collector($collector_info)."</p>";

                echo "<p> Lab Info: </p>";

                $result = pg_query($db, "SELECT * FROM labs WHERE lab_id = $collector_info[1]");

                while($row = pg_fetch_row($result)) {
                    echo "<p> $row[1]   $row[2]   $row[3] </p>";
                }
            }
        ?>

        <form name="form" action="collector_info.php">
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