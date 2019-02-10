<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Bacon</title>
    </head>

    <body>

        This is the start! <br>
        <input id="inp" type="text" oninput="show()"/>
        <div id="theD"></div>

        <script>

            function show() {
                xmlHttp = new XMLHttpRequest();
                let info = document.getElementById('inp').value;
                xmlHttp.open("GET", "patient_search.php?info="+info, true);
                xmlHttp.onreadystatechange = function () {
                    let root = xmlHttp.responseXML.documentElement;
                    let result = document.getElementById("theD");
                    let names = root.getElementsByTagName("name");
                    let emails = root.getElementsByTagName("email");
                    result.innerHTML = "";
                    for(let i=0; i<names.length; i++) {
                         result.innerHTML += (names.item(i).firstChild.data + " - " + emails.item(i).firstChild.data + "<br>");
                    }
                };
                xmlHttp.send(null);
            }

        </script>

        This is ok!

    </body>

</html>