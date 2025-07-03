<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST['student_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=? WHERE student_id=?");
  $stmt->bind_param("sssi", $name, $email, $phone, $id);

  if ($stmt->execute()) {
    echo "<script>alert('Student updated successfully'); window.location.href='../../index.php';</script>";
  } else {
    echo "<script>alert('Update failed'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
