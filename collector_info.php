<?php
    session_start();
    require 'connection.php';

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: logout.php");
    }

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

    function print_lab($collector_row) {
        echo "<a href=\"lab_info.php?id=$collector_row[0]\">$collector_row[0]</a> ";
        for($i=1; $i<sizeof($collector_row); $i++) {
            echo " - $collector_row[$i]";
        }
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
        $result = pg_query($db, "SELECT * FROM labs");
        while($row = pg_fetch_row($result)) {
            print_lab($row);
            echo "<br>";
        }
    } else {
        print_lab($lab_info);
        echo "<br><br><br>Tests offered by this lab: <br>";
        $result = pg_query($db, "SELECT * FROM tests WHERE test_id IN (SELECT test_id FROM offers WHERE lab_id = $lab_id)");
        while($row = pg_fetch_row($result)) {
            print_test($row);
            echo "<br>";
        }
    }
    /* la la la la la la */
    ?>

    </body>

    </html>

<?php pg_close($db) ?>