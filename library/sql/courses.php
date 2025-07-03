<?php 

//Db Connection
include '../db.php';

//Insert Courses into course table
$course_name = $_POST['course_name'];
$credits = $_POST['credits'];

$stmt = $conn->prepare("INSERT INTO 	courses(course_name, credits) VALUES(?, ?)");
$stmt->bind_param("si", $course_name, $credits);

if ($stmt->execute()) {
    echo "<script>
        alert('Course added successfully!');
        window.location.href = '../../index.php'; 
    </script>";
} else {
    echo "<script>
        alert('Error: " . $stmt->error . "');
        window.history.back(); 
    </script>";
}

$stmt->close();
$conn->close();

?>