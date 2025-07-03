<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate inputs
    $student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    if ($student_id === 0 || empty($name) || empty($email) || empty($phone)) {
        echo "<script>alert('Invalid input data.'); window.history.back();</script>";
        exit();
    }

    // Prepare update query
    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ? WHERE student_id = ?");
    $stmt->bind_param("sssi", $name, $email, $phone, $student_id);

    if ($stmt->execute()) {
        echo "<script>alert('Student updated successfully!'); window.location.href='../../index.php';</script>";
    } else {
        echo "<script>alert('Update failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
