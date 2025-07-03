<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $course_id = $_POST['course_id'];

  $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ?");
  $stmt->bind_param("i", $course_id);

  if ($stmt->execute()) {
    echo "<script>alert('Course deleted successfully'); window.location.href='../../index.php';</script>";
  } else {
    echo "<script>alert('Deletion failed'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
