<!-- code from Redwanul Haque -->

<?php
    session_start();
    require 'connection.php';

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "patient") {
        header("Location: logout.php");
    }

    if(!isset($_GET['id']))
        $all = true;
    else
        $all = false;

    if(!$all) {
        $lab_id = $_GET['id'];

        $lab_info = pg_fetch_row(pg_query($db, "SELECT * FROM labs WHERE lab_id = $lab_id"));

        if(!$lab_info)
            header("Location: lab_info.php");
    }

    function print_lab($lab_row) {
        echo "<a href=\"lab_info.php?id=$lab_row[0]\"> <strong> $lab_row[1] </strong> </a> ";

        for($i=2; $i<4; $i++) {
            // sizeof($lab_row)
            echo " - $lab_row[$i]";
        }
    }

    function print_test($test_row, $cost) {
        echo "<a href=\"test_info.php?id=$test_row[0]\"> <strong> $test_row[1] </strong> </a> ";

        for($i=1; $i<5; $i++) {
            echo "   $test_row[$i]";
        }

        echo "   (charges: tk.".$cost.")";
    }
?>




<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                if($all)
                    echo "Lab List";
                else
                    echo "$lab_info[1]";
            ?>
        </title>
    </head>

    <body>
        <?php
            if($all) {
                echo "<p> <h2> Labs </h2> </p>";

                $result = pg_query($db, "SELECT * FROM labs");

                while($row = pg_fetch_row($result)) {
                    echo "<p>".print_lab($row)."</p>";
                }
            } else {
                echo "<p> <strong> Lab: </strong> </p>";

                echo "<p>".print_lab($lab_info)."</p>";

                echo "<p> <strong> Tests offered by this lab: </strong> </p>";

                $result = pg_query($db, "SELECT * FROM tests WHERE test_id IN (SELECT test_id FROM offers WHERE lab_id = $lab_id)");

                while($row = pg_fetch_row($result)) {
                    $temp = pg_fetch_row(pg_query($db, "SELECT * FROM offers WHERE test_id = $row[0] AND lab_id = $lab_info[0]"));
                    $cost = $temp[2];

                    echo "<p>".print_test($row, $cost)."</p>";
                }
            }
        ?>

        <form name="form" action="lab_info.php">
            <br/>

            <p>
                <input type="button" onclick="window.location = 'back_to_home.php';" name="back" value="back"/>
                <input type="button" onclick="window.location = 'logOut.php';" name="logOut" value="log out"/>
            </p>
        </form>
    </body>
</html>

<?php
    pg_close($db)
?>
