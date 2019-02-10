<?php
    session_start();
    require 'connection.php';

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if(!isset($_GET['id']))
        $all = true;
    else
        $all = false;

    if(!$all) {
        $test_id = $_GET['id'];

        $test_info = pg_fetch_row(pg_query($db, "SELECT test_id, name, description, organ, disease FROM tests WHERE test_id = $test_id"));

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

    function print_our_test($test_row) {
        echo "<a href=\"test_info.php?id=$test_row[0]\"> <strong> $test_row[1] </strong> </a> ";

        for($i=2; $i<sizeof($test_row)-1; $i++) {
            // sizeof($test_row)
            echo " - $test_row[$i]";
        }

        echo " - (we charge ".$test_row[sizeof($test_row)-1]." tk for this test)";
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

        <form action="test_info.php" method="get">
            <label for="search">Search For Test: </label>
            <input id="search" type="text" name="search">
            <input type="submit" value="Search">
        </form>

        <?php
            if($all) {
                $add = "";
                if(isset($_GET['search'])) {
                    $add = " ORDER BY lcs(T.name,'".$_GET['search']."') DESC";
                }
                if($_SESSION['role'] == 'lab admin' || $_SESSION['role'] == 'collector') {

                    if($_SESSION['role'] == 'collector') {
                        $collector_id = $_SESSION['id'];
                        $lab_id = pg_fetch_row(pg_query("SELECT lab_id FROM collectors WHERE collector_id = $collector_id "))[0];
                    }
                    else {
                        $lab_id = $_SESSION['id'];
                    }

                    echo "<p> <h2> Our Tests: </h2> </p>";
                    $result = pg_query($db, "SELECT T.test_id, T.name, T.description, T.organ, T.disease, 
                                                    (SELECT O.charge FROM offers O WHERE O.test_id = T.test_id AND O.lab_id = $lab_id)
                                                    FROM tests T 
                                                    WHERE T.test_id IN (SELECT O.test_id FROM offers O WHERE O.lab_id = $lab_id )".$add);

                    while($row = pg_fetch_row($result)) {
                        echo "<p>";
                        print_our_test($row);
                        echo "</p>";  // IMPORTANT
                    }

                    echo "<br><p> <h2> Other Tests: </h2> </p>";
                    $result = pg_query($db, "SELECT T.test_id, T.name, T.description, T.organ, T.disease FROM tests T 
                                                    WHERE T.test_id NOT IN (SELECT O.test_id FROM offers O WHERE O.lab_id = $lab_id )".$add);

                    while($row = pg_fetch_row($result)) {
                        echo "<p>";
                        print_test($row);
                        echo "</p>";  // IMPORTANT
                    }
                }
                else if($_SESSION['role'] == 'patient') {
                    echo "<p> <h2> Tests: </h2> </p>";

                    $result = pg_query($db, "SELECT T.test_id, T.name, T.description, T.organ, T.disease FROM tests T".$add);

                    while($row = pg_fetch_row($result)) {
                        echo "<p>";
                        print_test($row);
                        echo "<a href=\"test_info.php?id=$row[0]\">Book</a> </p>";  // IMPORTANT
                    }
                }
            }
            else {
                echo "<p> <strong> Test: </strong> </p>";

                echo "<p>";
                print_test($test_info);
                echo "</p> <br/>";

                echo "<p> <strong> Labs that offer this test: </strong> </p>";

                $result = pg_query($db, "SELECT LB.lab_id, LB.name, LB.email, LB.phone_no,
                            (SELECT LC.address FROM locations LC WHERE LC.location_id = LB.location_id) location_name, O.charge
                            FROM labs LB JOIN offers O ON (LB.lab_id = O.lab_id)
                            WHERE O.test_id = $test_id");

                echo "<form id='book' action='book_test.php' method='get'><input id='lab' hidden><input id='test' hidden>";
                $cnt = 0;
                while($row = pg_fetch_row($result)) {
                    echo "<p id=\"p$cnt\">";
                    print_lab($row);
                    echo "<a onclick='add_date($cnt)' href='#'>Book</a></p>";
                    $cnt++;
                }
                echo "</form>";
                echo "<script> 
                    function add_date(cnt) {
                        let date = document.createElement('input');
                        date.type = 'date';
                        let submit = document.createElement('input');
                        submit.type = 'submit';
                        submit.value = 'Submit';
                        submit.onclick = function() {
                            document.getElementById('lab').value = $row[0];
                            document.getElementById('test_id').value = $test_id;
                            document.getElementById('book').submit();
                        };
                        let para = document.getElementById('p'+cnt);
                        para.appendChild(date);
                        para.appendChild(submit);
                    }
                </script>";
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
