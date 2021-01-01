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
        $studentID = strtolower($_POST['stRetName']);

        $sql = "SELECT major FROM students WHERE idstudents = '$studentID'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if(mysqli_num_rows($result) > 0){
            $stMajor = strtolower(mysqli_fetch_row($result)[0]);
        }else{
            echo "Student not found";
            echo '<br><a href="index.html">Back To Main Page</a>';
            exit;
        }

        $sql = "SELECT idprofessors FROM professors WHERE prof_major = '$stMajor' AND is_advisor=1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }
        if(mysqli_num_rows($result) > 0){
            $profID = mysqli_fetch_row($result)[0];
        }else{
            echo "No pefessor available";
            echo '<br><a href="index.html">Back To Main Page</a>';
            exit;
        }

        $sql = "SELECT * FROM professors WHERE idprofessors = '$profID'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "ID: " . $row["idprofessors"]. " - Name: " . $row["name"]. " - Phone " . $row["phone"]. " - Address:" . $row["address"]. " - E-mail:" . $row["email"]."<br><br>";
            }
            echo '<br><a href="index.html">Back To Main Library Page</a>';
        } else {
            echo "0 results";
        }

        $sql = "INSERT INTO students_has_professors (students_idstudents,professors_idprofessors) VALUES ('$studentID','$profID')";

        if (mysqli_query($conn, $sql)) {
            echo '<br><a href="index.html">Back To Main Page</a>';
        } else {
            echo "<br>Already Selected";

        }

?>