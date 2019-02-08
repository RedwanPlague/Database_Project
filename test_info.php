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
        $test_id = $_GET['id'];

        $test_info = pg_fetch_row(pg_query($db, "SELECT * FROM tests WHERE test_id = $test_id"));

        if(!$test_info)
            header("Location: test_info.php");
    }

    function print_test($test_row) {
        echo "<a href=\"test_info.php?id=$test_row[0]\"> <strong> $test_row[1] </strong> </a> ";

        for($i=2; $i<sizeof($test_row); $i++) {
            // sizeof($test_row)
            echo " - $test_row[$i]";
        }
    }

    function print_lab($lab_row) {
        echo "<a href=\"lab_info.php?id=$lab_row[0]\"> <strong> $lab_row[1] </strong> </a> ";

        for($i=2; $i<sizeof($lab_row)-1; $i++) {
            echo " - $lab_row[$i]";
        }

        echo " - (charges: tk.".$lab_row[sizeof($lab_row)-1].")";
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                if($all)
                    echo "test list";
                else
                    echo "$test_info[1]";
            ?>
        </title>
    </head>

    <body>
        <?php
            if($all) {
                echo "<p> <h2> Tests </h2> </p>";

                $result = pg_query($db, "SELECT * FROM tests");

                while($row = pg_fetch_row($result)) {
                    echo "<p>".print_test($row)."</p>";  // IMPORTANT
                }
            } else {
                echo "<p> <strong> Test: </strong> </p>";

                echo "<p>".print_test($test_info)."</p> <br/>";

                echo "<p> <strong> Labs that offer this test: </strong> </p>";

                $result = pg_query($db, "SELECT LB.lab_id, LB.name, LB.email, LB.phone_no,
                            (SELECT LC.address FROM locations LC WHERE LC.location_id = LB.location_id) location_name, O.charge
                            FROM labs LB JOIN offers O ON (LB.lab_id = O.lab_id)
                            WHERE O.test_id = $test_id");

                while($row = pg_fetch_row($result)) {
                    echo "<p>".print_lab($row)."</p>";
                }
            }
        ?>

        <form name="form" action="test_info.php">
            <br/>

            <p> <input type="button" onclick="window.location = 'back_to_home.php';" name="home" value="home"/>
                <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/>
            </p>
        </form>
    </body>
</html>

<?php
    pg_close($db)
?>
