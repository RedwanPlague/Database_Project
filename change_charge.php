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
    $query = pg_query("SELECT T.test_id, T.name, T.description, T.organ, T.disease, 
                                (SELECT O.charge FROM offers O WHERE O.test_id = T.test_id AND O.lab_id = $lab_id)
                                FROM tests T 
                                WHERE T.test_id = $test_id");

    if(!$query) {
        header('Location: test_info.php');
    }

    if(isset($_GET['to'])) {
        pg_query("UPDATE offers SET charge = ".$_GET['to']." WHERE lab_id = $lab_id AND test_id = $test_id");
        header('Location: test_info.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Change Test Charge</title>
    </head>

    <body>

        <h1>Be sure before changing the charge of this test</h1>

        <?php
            $row = pg_fetch_row($query);
            echo "<p><h2>$row[1]</h2><br>$row[2] - $row[3] - $row[4] - charge : $row[5]</p><br>";
        ?>

        <form action="change_charge.php" method="get">
            <label for="to">Change new charge to: </label>
            <input type="text" name="id" value="<?php echo $test_id; ?>" hidden>
            <input id="to" type="text" name="to">
            <input type="submit" value="Change">
        </form>

    </body>
</html>

<?php pg_close($db); ?>
