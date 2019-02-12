<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION['role'] != 'lab admin' && $_SESSION['role'] != 'collector') {
        header('Location: back_to_home.php');
    }

    require 'connection.php';

    $lab_id = $_SESSION['id'];

    $result = pg_query("SELECT
                            S.test_id,
                            (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
                            count(*)
                        FROM samples S
                        WHERE S.diagnosis_id IN (SELECT D.diagnosis_id FROM diagnosis D WHERE D.lab_id = $lab_id)
                        GROUP BY S.test_id 
                        ORDER BY count(*) DESC ");

    echo "<ul>Tests:";
    while($row = pg_fetch_row($result)) {
        echo "<li><a href=\"test_info.php?id=$row[0]\">$row[1]</a> - $row[2]</li>";
    }
    echo "</ul><br>";

    $result = pg_query("SELECT
                            D.collector_id,
                            (SELECT C.name FROM collectors C WHERE C.collector_id = D.collector_id),
                            count(*)
                        FROM diagnosis D
                        WHERE D.lab_id = $lab_id
                        GROUP BY D.collector_id
                        ORDER BY count(*) DESC ");

    echo "<ul>Collectors:";
    while($row = pg_fetch_row($result)) {
        echo "<li><a href=\"collector_info.php?id=$row[0]\">$row[1]</a> - $row[2]</li>";
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


