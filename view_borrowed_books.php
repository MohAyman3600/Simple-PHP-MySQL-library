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
       

        $sql = "SELECT * FROM book_library_has_students";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo '<br>';
                echo "Student ID: " . $row["students_idstudents"]. " - Book ID: " . $row["book_library_idBook_Library"]. " - Borrow Date: " . $row["borrow_date"]." - Retrieval Date: " . $row["retrieval_date"]." - Penalty: " . $row["penalty"]." - Order ID: ".$row["book_library_has_studentscol"]."<br>";
            }
            echo '<br><a href="index.html">Back To Main Library Page</a>';
        } else {
            echo "0 results";
        }
?>