<?php
    session_start();
    require "connection.php";

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "patient") {
        header("Location: back_to_home.php");
    }

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
                $query = pg_query($db, "SELECT name FROM patients WHERE patient_id = $id");
                $row = pg_fetch_row($query);

                echo $row[0];
            ?>
        </title>
    </head>

    <body>

        <form name="form" action="patient_page.php">
            <p> <input type="button" onclick="window.location = 'lab_info.php';" name="visitLab" value="visit lab"/> </p>
            <p> <input type="button" onclick="window.location = 'test_info.php';" name="bookTest" value="book test"/> </p>
            <p> <input type="button" onclick="window.location = 'patient_page.php?which=1';" name="patientBookings" value="See Previous Bookings"/> </p>
            <p> <input type="button" onclick="window.location = 'patient_page.php?which=2';" name="testIssues" value="See Issued Tests"/> </p>
            <br/>
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>

        <?php
            if($which == 1) {
                show_prev_history($id);
            }
            else if($which == 2) {
                show_issued_test($id);
            }

            function show_prev_history($id) {
                echo "<br><ul>Your Previous Finished Tests:";

                $query = pg_query("SELECT 
                    (SELECT L.name FROM labs L WHERE L.lab_id = D.lab_id), 
                    (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
                    D.collection_date,
                    (SELECT R.content FROM reports R WHERE R.report_id = S.report_id)
                    FROM samples S JOIN diagnosis D ON S.diagnosis_id = D.diagnosis_id
                    WHERE S.diagnosis_id IN 
                        (SELECT D.diagnosis_id FROM diagnosis D WHERE D.patient_id = $id )
                    ORDER BY D.collection_date DESC ");

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

            function show_issued_test($id) {
                echo "<br><ul>The tests issued for you:";

                $query = pg_query("SELECT 
                                    I.test_id,
                                    (SELECT T.name FROM tests T WHERE T.test_id = I.test_id),
                                    (SELECT D.name FROM doctors D WHERE D.doctor_id = P.doctor_id)
                                    FROM issued I JOIN prescriptions P ON I.prescription_id = P.prescription_id
                                    WHERE P.patient_id = $id ");

                while($row = pg_fetch_row($query)) {
                    echo "<li>$row[2] - <a href=\"test_info.php?id=$row[0]\">$row[1]</a></li>";
                }

                echo "</ul>";
            }

        ?>

    </body>
</html>

<?php
    pg_close($db)
?>