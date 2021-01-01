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
        $bookName = strtolower($_POST['bookRetName']);
        $studentName = $_POST['stRetName'];

        $sql = "SELECT book_library_idBook_Library FROM book_library_has_students  WHERE Book_name = '$bookName'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if(mysqli_num_rows($result) < 0){
            echo 'Book not found';
            $register = false;
            exit;
        }else{
            $bookID = mysqli_fetch_row($result);
        }

        $sql = "SELECT name FROM students WHERE idstudents = '$studentName'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<br>";
            echo 'Could not run query:' . mysql_error();
            exit;
        }
         if(mysqli_num_rows($result) > 0){
            $stID = mysqli_fetch_row($result);
        }else{
             echo "<br>";
             echo "Student not found";
             $register = false;
             exit;
        }


        $sql = "SELECT students_idstudents FROM book_library_has_students WHERE students_idstudents = '$studentName'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<br>";
            echo 'Could not run query:' . mysql_error();
            exit;
        }
         if(mysqli_num_rows($result) < 0){
             echo "<br>";
             echo "Student did not borrow a book";
             $register = false;
             exit;
        }

        $sql = "SELECT retrieval_date FROM book_library_has_students WHERE book_library_idBook_Library = '$bookID[0]'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<br>";
            echo 'Could not run query:' . mysql_error();
            exit;
        }
         if(mysqli_num_rows($result) > 0){
             $retDate = mysqli_fetch_row($result);
        }

        $current_date = date("Y/m/d");
        $current_date = strtotime($current_date);
        $retDate = strtotime($retDate[0]);
        echo '<br>';
        $daysSinceBorrow =  ((($current_date - $retDate)/60)/60)/24;
        if($daysSinceBorrow > 0){
             $penalty = 10*$daysSinceBorrow;
        }else{
            $penalty = 0;
        }
        $penalty = strval($penalty);
        $sql = "UPDATE book_library_has_students SET penalty = '$penalty'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        $sql = "SELECT students_idstudents,book_library_idBook_Library,borrow_date,retrieval_date,penalty,Book_name,book_library_has_studentscol FROM book_library_has_students WHERE book_library_idBook_Library = '$bookID[0]'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo '<br>';
                echo "Student ID: " . $row["students_idstudents"]. " - Book ID: " . $row["book_library_idBook_Library"]. " - Borrow Date: " . $row["borrow_date"]." - Retrieval Date: " . $row["retrieval_date"]." - Penalty: " . $row["penalty"]."<br>";
                $orderID = $row["book_library_has_studentscol"];
            }
        }
        $sql= "DELETE FROM book_library_has_students WHERE book_library_idBook_Library = '$bookID[0]'";
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
            echo '<br><a href="index.html">Back To Main Library Page</a>';
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
?>
