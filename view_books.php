<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_uni";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
       

        $sql = "SELECT * FROM book_library";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "ID: " . $row["idBook_Library"]. " - Title: " . $row["Title"]. " - Author " . $row["Author"]. " - Description:" . $row["Description"]. "<br><br>";
            }
            echo '<br><a href="index.html">Back To Main Library Page</a>';
        } else {
            echo "0 results";
        }
?>