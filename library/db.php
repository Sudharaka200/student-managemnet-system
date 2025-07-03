<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "student_management_systemdb";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo "Database Connection failed: " . $conn->connect_error;
    exit();
}

?>