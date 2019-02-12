<?php
    session_start();
    require "connection.php";

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "collector") {
        header("Location: back_to_home.php");
    }

    $collector_id = $_SESSION['id'];
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                $query = pg_query($db, "SELECT name FROM collectors WHERE collector_id = $collector_id");
                $row = pg_fetch_row($query);

                echo $row[0];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="collector_page.php">
            <p> <input type="button" onclick="window.location = 'statistics.php';" name="statistics" value="See Statistics"/> </p>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>

        <?php
            $query = pg_query(
            "SELECT
                            S.diagnosis_id, S.test_id,
                           (SELECT P.name FROM patients P WHERE P.patient_id = D.patient_id),
                           (SELECT LC.address FROM locations LC WHERE location_id = (SELECT P.location_id FROM patients P WHERE P.patient_id = D.patient_id)),
                           (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
                           D.collection_date
                        FROM samples S JOIN diagnosis D ON S.diagnosis_id = D.diagnosis_id
                        WHERE D.collector_id = $collector_id AND NOT S.collected
                        ORDER BY D.collection_date DESC");
            echo "<ul>Your Upcoming Jobs: ";
            while($row = pg_fetch_row($query)) {
                echo "<li>$row[2] - $row[3] - $row[4] - $row[5] - <a href=\"collected.php?dig=$row[0]&test=$row[1]\">Collected</a> </li>";
            }
            echo "</ul>";
            $query = pg_query(
            "SELECT
                           (SELECT P.name FROM patients P WHERE P.patient_id = D.patient_id),
                           (SELECT LC.address FROM locations LC WHERE location_id = (SELECT P.location_id FROM patients P WHERE P.patient_id = D.patient_id)),
                           (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
                           D.collection_date
                        FROM samples S JOIN diagnosis D ON S.diagnosis_id = D.diagnosis_id
                        WHERE D.collector_id = $collector_id AND S.collected 
                        ORDER BY D.collection_date DESC");
            echo "<ul>Your Completed Jobs: ";
            while($row = pg_fetch_row($query)) {
                echo "<li>$row[0] - $row[1] - $row[2] - $row[3]</li>";
            }
        echo "</ul>";
        ?>

    </body>
</html>

<?php
    pg_close($db)
?>