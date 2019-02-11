<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "patient") {
        header("Location: logout.php");
    }

    require "connection.php";

    $id = $_SESSION["id"];
    $which = 0;

    if(isset($_GET['which'])) {
        $which = $_GET['which']; // cannot be 0 as 0 is default
    }
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                $id = $_SESSION["id"];
                $query = pg_query($db, "SELECT * FROM patients WHERE patient_id = $id");
                $row = pg_fetch_row($query);

                echo $row[1];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="patient_page.php">
            <p> <input type="button" onclick="window.location = 'lab_info.php';" name="visitLab" value="visit lab"/> </p>
            <p> <input type="button" onclick="window.location = 'test_info.php';" name="knowTest" value="know test"/> </p>
            <p> <input type="button" onclick="window.location = 'test_book.php';" name="bookTest" value="book test"/> </p>
            <br/>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>

        <?php
            if($which == 1) {
                show_prev_history($id);
            }

            else {
                show_book_test();
            }

            function show_prev_history($id) {
                echo "<br><ul>Your Previous Finished Tests:";

                $query = pg_query("SELECT 
                    (SELECT L.name FROM labs L WHERE L.lab_id = (SELECT D.lab_id FROM diagnosis D WHERE D.diagnosis_id = S.diagnosis_id)), 
                    (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
                    S.issue_time,
                    (SELECT R.content FROM reports R WHERE R.report_id = S.report_id)
                    FROM samples S 
                    WHERE S.diagnosis_id IN 
                        (SELECT D.diagnosis_id FROM diagnosis D WHERE D.patient_id = $id )
                    ORDER BY S.issue_time DESC ");

                while($row = pg_fetch_row($query)) {
                    echo "<li>$row[0] - $row[1] - $row[2] - ";

                    if($row[3] == null) {
                        echo "processing";
                    } else {
                        echo "<a href='$row[3]' download>Get Report</a>";
                    }
                                        echo "</li>";
                }

                echo "</ul>";
            }

            function show_book_test() {

            }
        ?>
    </body>
</html>

<?php
    pg_close($db)
?>