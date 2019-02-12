<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: back_to_home.php");
    }

    require 'connection.php';

    $lab_id = $_SESSION['id'];

    $result = pg_query("SELECT
            D.diagnosis_id,
            (SELECT P.name FROM patients P WHERE P.patient_id = D.patient_id),
            (SELECT LC.address FROM locations LC WHERE location_id = (SELECT P.location_id FROM patients P WHERE P.patient_id = D.patient_id)),
            (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
            D.collection_date
        FROM diagnosis D JOIN samples S ON D.diagnosis_id = S.diagnosis_id
        WHERE D.lab_id = $lab_id AND D.collector_id IS NULL
        ORDER BY D.collection_date DESC ");

    echo "<ul>Collector Not assigned:";
    while($row = pg_fetch_row($result)) {
        echo "<li>$row[1] - $row[2] - $row[3] - $row[4] - <a href='assign_collector.php?dig=".$row[0]."'>Assign</a> </li>";
    }
    echo "</ul><br>";

    $result = pg_query("SELECT
            D.diagnosis_id,
            (SELECT P.name FROM patients P WHERE P.patient_id = D.patient_id),
            (SELECT LC.address FROM locations LC WHERE location_id = (SELECT P.location_id FROM patients P WHERE P.patient_id = D.patient_id)),
            (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
            (SELECT C.name FROM collectors C WHERE C.collector_id = D.collector_id),
            D.collection_date
        FROM diagnosis D JOIN samples S ON D.diagnosis_id = S.diagnosis_id
        WHERE D.lab_id = $lab_id AND D.collector_id IS NOT NULL 
        ORDER BY D.collection_date DESC ");

    echo "<ul>Collector already assigned:";
    while($row = pg_fetch_row($result)) {
        echo "<li>$row[0] - $row[1] - $row[2] - $row[3] - $row[4]</li>";
    }
    echo "</ul>";

    echo <<<LINE
        <form name="form" action="lab_test_info.php">
        <br/>
        <p> <input type="button" onclick="window.location = 'back_to_home.php';" name="home" value="home"/>
            <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/>
        </p>
        </form>
LINE;


    pg_close($db);

?>