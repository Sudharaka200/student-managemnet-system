<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST['course_id'];
  $name = $_POST['course_name'];
  $credits = $_POST['credits'];

  $stmt = $conn->prepare("UPDATE courses SET course_name=?, credits=? WHERE course_id=?");
  $stmt->bind_param("sii", $name, $credits, $id);

  if ($stmt->execute()) {
    echo "<script>alert('Course updated successfully'); window.location.href='../../index.php';</script>";
  } else {
    echo "<script>alert('Update failed'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
