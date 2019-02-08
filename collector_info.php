<?php
    session_start();
    require 'connection.php';

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "lab admin") {
        header("Location: back_to_home.php");
    }

    $lab_id = $_SESSION['id'];

    if(!isset($_GET['id']))
        $all = true;
    else
        $all = false;

    if(!$all) {
        $collector_id = $_GET['id'];
        $collector_info = pg_fetch_row(pg_query($db, "SELECT collector_id, name, email, phone_no FROM collectors WHERE collector_id = $collector_id AND lab_id = $lab_id"));
        if(!$collector_info)
            header("Location: collector_info.php");
    }

    function print_collector($collector_row) {
        echo "<a href=\"collector_info.php?id=$collector_row[0]\">$collector_row[1]</a> ";
        for($i=2; $i<sizeof($collector_row); $i++) {
            echo " - $collector_row[$i]";
        }
    }

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
      <title>
          <?php
          if($all)
              echo "Collector List";
          else
              echo "$collector_info[2]";
          ?>
      </title>
  </head>

  <body>

  <?php
  if($all) {
      $result = pg_query($db, "SELECT collector_id, name, email, phone_no FROM collectors WHERE lab_id = $lab_id");
      while($row = pg_fetch_row($result)) {
          print_collector($row);
          echo "<br>";
      }
  } else {
      print_collector($collector_info);
      echo "<br><br><br>Tasks Performed by this Collector: <br><br>";
      $result = pg_query($db, "SELECT P.name,
                    (SELECT LC.address FROM locations LC WHERE LC.location_id = P.location_id) AS location,
                    D.collection_date
                    FROM diagnosis D JOIN patients P ON (D.patient_id = P.patient_id)
                    WHERE D.collector_id = $collector_id");
      while($row = pg_fetch_row($result)) {
          for($i=0; $i<sizeof($row); $i++) {
              echo "$row[$i] - ";
          }
          echo "<br>";
      }
  }

  ?>

  <form name="form" action="collector_info.php">
      <br/>

      <p>
          <input type="button" onclick="window.location = 'back_to_home.php';" name="home" value="home"/>
          <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/>
      </p>
  </form>

  </body>

</html>

<?php pg_close($db) ?>
