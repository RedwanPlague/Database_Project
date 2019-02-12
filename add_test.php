<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin" || !isset($_GET['id'])) {
        header("Location: back_to_home.php");
    }

    require 'connection.php';

    $lab_id = $_SESSION['id'];
    $test_id = $_GET['id'];

    /*$check = pg_fetch_row(pg_query("SELECT exists(SELECT O.charge FROM offers O WHERE O.lab_id = $lab_id AND O.test_id = $test_id)"))[0];
    if($check) {
        header('Location: test_info.php');
    }
    echo $check;*/

    $query = pg_query("SELECT T.name, T.description, T.organ, T.disease 
                                    FROM tests T 
                                    WHERE T.test_id = $test_id");

    if(!$query) {
        header('Location: test_info.php');
    }

    if(isset($_GET['charge'])) {
        $charge = $_GET['charge'];
        pg_query("INSERT INTO offers VALUES ($lab_id, $test_id, $charge)");
        header('Location: test_info.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Test to Lab</title>
</head>

<body>

    <h1>Be sure before adding this test to lab</h1>

    <?php
        $row = pg_fetch_row($query);
        echo "<p><h2>$row[0]</h2><br>$row[1] - $row[2] - $row[3]</p><br>";
    ?>

    <form action="add_test.php" method="get">
        <label for="charge">Set charge for this test: </label>
        <input type="text" name="id" value="<?php echo $test_id; ?>" hidden>
        <input id="charge" type="text" name="charge">
        <input type="submit" value="Add">
    </form>

</body>
</html>

<?php pg_close($db); ?>
