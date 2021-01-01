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
        $bookName = strtolower($_POST['bookName']);
        $studentName = strtolower($_POST['stName']);
        
        $register = true;
        $sql = "SELECT idBook_Library FROM book_library WHERE Title = '$bookName'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if(mysqli_num_rows($result) > 0){
            $bookID = mysqli_fetch_row($result);
        }else{
            echo "Book not found";
            echo '<br><a href="index.html">Back To Main Page</a>';
            $register = false;
            exit;
        }
        
        $sql = "SELECT Book_name FROM book_library_has_students  WHERE book_library_idBook_Library = '$bookID[0]'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if(mysqli_num_rows($result) > 0){
            echo 'Book already taken';
            echo '<br><a href="index.html">Back To Main Page</a>';
            $register = false;
            exit;
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
             echo '<br><a href="index.html">Back To Main Page</a>';
             $register = false;
             exit;
        }

        $current_date = date("Y/m/d");
        $date = date_create($current_date);
        date_add($date, date_interval_create_from_date_string('7 days'));
        $ret_date = date_format($date, 'Y-m-d');

        if($register){
            $sql = "INSERT INTO book_library_has_students (students_idstudents,book_library_idBook_Library,borrow_date,retrieval_date,Book_name) VALUES ('$studentName','$bookID[0]','$current_date','$ret_date','$bookName')";

            if (mysqli_query($conn, $sql)) {
                echo "Book Registerd Successfully";
                echo '<br><a href="index.html">Back To Main Page</a>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

?>