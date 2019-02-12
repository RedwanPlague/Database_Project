<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin" || !isset($_GET['dig'])) {
        header("Location: back_to_home.php");
    }

    require "connection.php";
    $lab_id = $_SESSION["id"];
    $diag_id = $_GET['dig'];

    if(isset($_GET['id'])) {
        $collector_id = $_GET['id'];
        pg_query("UPDATE diagnosis SET collector_id = $collector_id WHERE diagnosis_id = $diag_id");
        header('Location: sample_info.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Collector Assigner</title>
    </head>
<body>

    <?php

        $result = pg_query("SELECT
                D.collector_id,
                D.collection_date,
                (SELECT C.name FROM collectors C WHERE C.collector_id = D.collector_id),
                count(*)
            FROM diagnosis D
            WHERE D.lab_id = $lab_id AND D.collector_id IS NOT NULL 
            GROUP BY D.collector_id, D.collection_date
            ORDER BY D.collection_date DESC ");

        echo "<ul>Jobs of collectors :";
        while($row = pg_fetch_row($result)) {
            echo "<li><a href=\"collector_info.php?id=$row[0]\">$row[2]</a> - $row[3] jobs - on $row[1]  -  <a href=\"assign_collector.php?id=$row[0]&dig=$diag_id\">Assign</a></li>";
        }
        echo "</ul>";

    ?>

</body>
</html>

<?php pg_close($db); ?>
