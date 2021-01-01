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
        $retDates = array();
        $sql = "SELECT retrieval_date FROM book_library_has_students";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                array_push($retDates,$row['retrieval_date']);  
            }
        } else {
            echo "0 results";
        }
        $current_date = date("Y/m/d");
        $current_date = strtotime($current_date);
        for($i = 0; $i<sizeof($retDates);$i++){
            $retDates[$i] = strtotime($retDates[$i]);
            $daysSinceBorrow =  ((($current_date - $retDates[$i])/60)/60)/24;
            if($daysSinceBorrow > 0){
                 $penalty = 10*$daysSinceBorrow;
            }else{
                $penalty = 0;
            }
            $penalty = strval($penalty);
            $sql = "UPDATE book_library_has_students SET penalty = '$penalty'";
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                exit;
            }      

        }
        echo 'Records Updated';
        echo '<br><a href="index.html">Back To Main Library Page</a>';

?>
        


               
