<?php
    header('Content-Type: text/xml');

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?><response>";

    require 'connection.php';

    $info = '.';

    if(isset($_GET['info']))
        $info = $_GET['info'];

    $result = pg_query($db,"SELECT test_id, name FROM tests ORDER BY lcs(name,'$info') DESC");

    while($row = pg_fetch_row($result)) {
        echo "<id>$row[0]</id><name>$row[1]</name>";
    }

    echo "</response>";

    pg_close($db);
?>