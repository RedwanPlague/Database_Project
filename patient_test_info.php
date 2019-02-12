<?php
    session_start();
    require 'connection.php';
    
    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }
    
    if($_SESSION['role'] != 'patient') {
        header('Location: back_to_home.php');
    }
    
    if(!isset($_GET['id']))
        $all = true;
    else
        $all = false;
    
    if(!$all) {
        $test_id = $_GET['id'];
    
        $test_info = pg_fetch_row(pg_query($db, "SELECT test_id, name, description, organ, disease FROM tests WHERE test_id = $test_id"));
    
        if(!$test_info)
            header("Location: patient_test_info.php");
    }
    
    function print_test($test_row) {
        echo "<a href=\"patient_test_info.php?id=$test_row[0]\"> <strong> $test_row[1] </strong> </a> ";
    
        for($i=2; $i<sizeof($test_row); $i++) {
            // sizeof($test_row)
            echo " - $test_row[$i] ";
        }
    }
    
    function print_lab($lab_row) {
        echo "<a href=\"lab_info.php?id=$lab_row[0]\"> <strong> $lab_row[1] </strong> </a> ";
    
        for($i=2; $i<sizeof($lab_row)-1; $i++) {
            echo " - $lab_row[$i]";
        }
    
        echo " - (charges: tk.".$lab_row[sizeof($lab_row)-1].") ";
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

    <form action="patient_test_info.php" method="get">
        <label for="search">Search For Test: </label>
        <input id="search" type="text" name="search">
        <label for="how">Search by:</label>
        <select id="how" name="by">
            <option name="name" value="name">Name</option>
            <option name="organ" value="organ">Organ</option>
            <option name="disease" value="disease">Disease</option>
        </select>
        <input type="submit" value="Search">
    </form>

    <?php
        if($all) {
            $add = "";
            if(isset($_GET['search']) && isset($_GET['by'])) {
                $search = $_GET['search'];
                $by = $_GET['by'];
                $add = " ORDER BY lcs(T.$by,'$search') DESC";
            }

            echo "<p> <h2> Tests: </h2> </p>";

            $result = pg_query($db, "SELECT T.test_id, T.name, T.description, T.organ, T.disease FROM tests T".$add);

            while($row = pg_fetch_row($result)) {
                echo "<p>";
                print_test($row);
                echo "<a href=\"patient_test_info.php?id=$row[0]\">Book</a> </p>";  // IMPORTANT
            }
        }
        else {
            echo "<p> <strong> Test: </strong> </p>";

            echo "<p>";
            print_test($test_info);
            echo "</p> <br/>";

            echo "<p> <strong> Labs that offer this test: </strong> </p>";

            echo <<<LINE
                <form action="patient_test_info.php" method="get">
                    <input type="text" name="id" value="$test_id" hidden>
                    Sort labs according to: <br>
                    <input type="radio" name="sort" value="price"> Price <br>
                    <input type="radio" name="sort" value="distance"> Distance <br>
                    <input type="submit" value="Sort">
                </form> <br>
LINE;
            $add = "";
            if (isset($_GET['sort'])) {
                $sort = $_GET['sort'];
                if ($sort == 'price') {
                    $add = " ORDER BY O.charge ASC ";
                } else if ($sort == 'distance') {
                    $patient_id = $_SESSION['id'];
                    $patient_loc = pg_fetch_row(pg_query("SELECT location_id FROM patients WHERE patient_id = $patient_id"))[0];
                    $add = " ORDER BY distance(LB.location_id,$patient_loc) ASC ";
                }
            }

            $result = pg_query($db, "SELECT LB.lab_id, LB.name, LB.email, LB.phone_no,
                                (SELECT LC.address FROM locations LC WHERE LC.location_id = LB.location_id) location_name, O.charge
                                FROM labs LB JOIN offers O ON (LB.lab_id = O.lab_id)
                                WHERE O.test_id = $test_id".$add);

            echo "<form id='book' action='book_test.php' method='get'><input id='lab' name='lab' hidden><input id='test' name='test' hidden>";
            echo "<input type='date' name='date'>";

            while ($row = pg_fetch_row($result)) {
                echo "<p>";
                print_lab($row);
                echo "<a onclick=\"add_date($row[0],$test_id)\" href='#'>Book</a></p>";
            }

            echo "</form>";
        }

    ?>

    <script>
        function add_date(lab,test) {
            document.getElementById('lab').value = lab;
            document.getElementById('test').value = test;
            document.getElementById('book').submit();
        }
    </script>

    <form name="form" action="patient_test_info.php">
        <br/>
        <p> <input type="button" onclick="window.location = 'back_to_home.php';" name="home" value="home"/>
            <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/>
        </p>
    </form>
</body>
</html>

<?php
    pg_close($db);
?>
