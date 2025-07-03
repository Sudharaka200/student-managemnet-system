<?php
include 'library/db.php';

$id = $_GET['id'];
$query = "SELECT * FROM courses WHERE course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Course</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h3 class="text-center text-primary">Edit Course</h3>
    <form action="library/sql/update_course.php" method="POST">
      <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
      <div class="mb-3">
        <label>Course Name</label>
        <input type="text" name="course_name" class="form-control" value="<?= htmlspecialchars($course['course_name']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Credits</label>
        <input type="number" name="credits" class="form-control" value="<?= htmlspecialchars($course['credits']) ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
