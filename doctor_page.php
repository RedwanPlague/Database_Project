<?php
    session_start();

    if(isset($_SESSION['logged_in']) == false) {
        header("Location: index.php");
    }

    if($_SESSION["role"] != "doctor") {
        header("Location: back_to_home.php");
    }

    require "connection.php";

    $id = $_SESSION["id"];
    $patient = "";
    $test = "";

    if(isset($_GET['patient'])) {
        $patient = $_GET['patient'];
    }
    if(isset($_GET['test'])) {
        $test = $_GET['test'];
    }

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>
            <?php
                $query = pg_query($db, "SELECT * FROM doctors WHERE doctor_id = $id");
                $row = pg_fetch_row($query);

                echo $row[1];
            ?>
        </title>
    </head>

    <body>
        <form name="form" action="doctor_page.php">
            <p> <input type="button" onclick="window.location = 'logout.php';" name="logOut" value="log out"/> </p>
        </form>

        <h2> Issue Tests From Here: </h2>

        <form action="issue_test.php" method="get">

            <label for="patient_match">Patient Name: </label>
            <input id="patient_match" type="text" oninput="show_patient()">
            <select name="patient">
                <?php
                    $result = pg_query($db,"SELECT patient_id, name, email FROM patients");
                    $cnt = 0;
                    while($row = pg_fetch_row($result)) {
                        echo "<option id=\"pop$cnt\" name=\"patient\" value='$row[0]'>$row[1] ($row[2])</option>";
                        $cnt++;
                    }
                ?>
            </select>

            <br>
            <label for="test_match">Test Name: </label>
            <input id="test_match" type="text" oninput="show_test()">
            <select name="test">
                <?php
                    $result = pg_query($db,"SELECT test_id, name FROM tests");
                    $cnt = 0;
                    while($row = pg_fetch_row($result)) {
                        echo "<option id=\"top$cnt\" name=\"test\" value='$row[0]'>$row[1]</option>";
                        $cnt++;
                    }
                ?>
            </select>

            <input type="submit" value="Issue">

        </form>

        <script>

            function show_patient() {
                xmlHttp = new XMLHttpRequest();
                let info = document.getElementById('patient_match').value;
                xmlHttp.open("GET", "patient_search.php?info="+info, true);
                xmlHttp.onreadystatechange = function () {
                    let root = xmlHttp.responseXML.documentElement;
                    let ids = root.getElementsByTagName('id');
                    let names = root.getElementsByTagName('name');
                    let emails = root.getElementsByTagName('email');
                    for(let i=0; i<names.length; i++) {
                        document.getElementById('pop'+i).value = ids.item(i).firstChild.data;
                        document.getElementById('pop'+i).innerHTML = names.item(i).firstChild.data + " (" + emails.item(i).firstChild.data + ")";
                    }
                };
                xmlHttp.send(null);
            }

            function show_test() {
                xmlHttp = new XMLHttpRequest();
                let info = document.getElementById('test_match').value;
                xmlHttp.open("GET", "test_search.php?info="+info, true);
                xmlHttp.onreadystatechange = function () {
                    let root = xmlHttp.responseXML.documentElement;
                    let ids = root.getElementsByTagName('id');
                    let names = root.getElementsByTagName('name');
                    for(let i=0; i<names.length; i++) {
                        document.getElementById('top'+i).value = ids.item(i).firstChild.data;
                        document.getElementById('top'+i).innerHTML = names.item(i).firstChild.data;
                    }
                };
                xmlHttp.send(null);
            }

        </script>

    </body>
</html>

<?php
    pg_close($db)
?>