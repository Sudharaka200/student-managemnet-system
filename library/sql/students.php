<?php 

//Db Connection
include '../db.php';

//Insert student into student table
$student_name = $_POST['student_name'];
$student_email = $_POST['student_email'];
$student_phonenumber = $_POST['student_phone'];

$stmt = $conn->prepare("INSERT INTO 	students(name, email, phone) VALUES(?, ?, ?)");
$stmt->bind_param("ssi", $student_name, $student_email, $student_phonenumber);

if ($stmt->execute()) {
    echo "<script>
        alert('Student added successfully!');
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