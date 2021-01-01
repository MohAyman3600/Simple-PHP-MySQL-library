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
        $bookName = strtolower($_POST['buyBookName']);
        $bookID = strtolower($_POST['buyBookId']);

        $sql= "DELETE FROM book_library WHERE idBook_Library = '$bookID' AND Title = '$bookName'";
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
            echo '<br><a href="index.html">Back To Main Library Page</a>';
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
?>