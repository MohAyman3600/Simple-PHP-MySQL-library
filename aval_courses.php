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
if (mysqli_num_rows($result) > 0) {
    $stMajor = strtolower(mysqli_fetch_row($result)[0]);
} else {
    echo "Student not found";
    echo '<br><a href="index.html">Back To Main Page</a>';
    exit;
}

$sql = "SELECT courses.idcourses, students_has_courses.courses_idcourses
        FROM courses
        INNER JOIN students_has_courses ON courses.idcourses = students_has_courses.courses_idcourses";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $num = 0;
    while ($row = mysqli_fetch_array($result)) {
        // output data of each row
        $stCourses[$num] = $row[$num];
        $num = $num + 1;
    }
} else {
    echo "courses not found";
    echo '<br><a href="index.html">Back To Main Page</a>';
    exit;
}

for ($i = 0; $i < $num; $i++) {
    $sql = "SELECT * FROM courses WHERE idcourses =
            (SELECT courses_idcourses FROM courses_has_prerequist WHERE courses_idcourses1_prereq = '$stCourses[$i]')
            AND major = '$stMajor' OR has_preq = 0 ";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row["idcourses"] . " - Desc: " . $row["course_description"] . " - Major: " . $row["major"] . " - Number of Credits: " . $row["no_credits"] . "<br><br>";
        }
    } else {
        echo "0 results";
        exit;
    }
}

echo '<br><a href="index.html">Back To Main Library Page</a>';
