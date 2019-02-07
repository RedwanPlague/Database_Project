<?php
    session_start();
    require 'connection.php';

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
        echo "<a href=\"lab_info.php?id=$lab_row[0]\">$lab_row[0]</a> ";
        for($i=1; $i<sizeof($lab_row); $i++) {
            echo " - $lab_row[$i]";
        }
    }

    function print_test($test_row) {
        echo "<a href=\"test_info.php?id=$test_row[0]\">$test_row[0]</a> ";
        for($i=1; $i<sizeof($test_row); $i++) {
            echo " - $test_row[$i]";
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

?>

</body>

</html>

<?php pg_close($db) ?>
