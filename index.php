<?php
// Db connection
include 'library/db.php';

// Select Students for dropdown
$sql_students = "SELECT * FROM students";
$result_students = $conn->query($sql_students);

// Select Courses for dropdown
$sql_courses = "SELECT course_id, course_name FROM courses";
$result_courses = $conn->query($sql_courses);

// Reload Students separately for student table
$result_students_table = $conn->query($sql_students);

// Select Enrollments
$sql_enrollments = "SELECT 
    s.student_id,
    s.name AS student_name,
    s.email,
    c.course_id,
    c.credits
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id";

$result_enrollments = $conn->query($sql_enrollments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Management System</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Add Students -->
<div class="container">
  <h1 class="text-center mt-5">Student Management System</h1>
  <div class="p-20">
    <form action="library/sql/students.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="student_name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="student_email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="number" class="form-control" name="student_phone" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<!-- Add Courses -->
<div class="container">
  <h1 class="text-center mt-5">Courses</h1>
  <div class="p-20">
    <form action="library/sql/courses.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Course Name</label>
        <input type="text" class="form-control" name="course_name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Credits</label>
        <input type="number" class="form-control" name="credits" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<!-- Enroll Student to Course -->
<div class="container">
  <h1 class="text-center mt-5">Enroll Student to Course</h1>
  <div class="p-20">
    <form action="library/sql/enrollment.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Select Student</label>
        <select class="form-select" name="student_id" required>
          <option selected disabled>Choose...</option>
          <?php
          if ($result_students->num_rows > 0) {
            while ($row = $result_students->fetch_assoc()) {
              echo '<option value="' . $row["student_id"] . '">' . htmlspecialchars($row["email"]) . '</option>';
            }
          } else {
            echo '<option disabled>No students found</option>';
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Select Course</label>
        <select class="form-select" name="course_id" required>
          <option selected disabled>Choose...</option>
          <?php
          if ($result_courses->num_rows > 0) {
            while ($row = $result_courses->fetch_assoc()) {
              echo '<option value="' . $row["course_id"] . '">' . htmlspecialchars($row["course_name"]) . '</option>';
            }
          } else {
            echo '<option disabled>No courses found</option>';
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<!-- Display All Students with enrolled courses-->
<div class="container mt-5">
  <h2>All Students</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result_students_table->num_rows > 0) {
        while ($row = $result_students_table->fetch_assoc()) {
          echo "<tr>
            <td>" . htmlspecialchars($row["student_id"]) . "</td>
            <td>" . htmlspecialchars($row["name"]) . "</td>
            <td>" . htmlspecialchars($row["email"]) . "</td>
            <td>" . htmlspecialchars($row["phone"]) . "</td>
            <td>
            <form action='library/sql/delete.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this student?\")'>
                <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
              </form>
            </td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No students found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<!-- Display Enrolled Courses -->
<div class="container mt-5">
  <h2 class="text-center">Enrolled Courses</h2>
  <!-- Display Enrolled Courses -->
<div class="container mt-5">
  <h2 class="text-center">Enrolled Courses</h2>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course Name</th>
        <th>Credits</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Run this query separately before the loop
      $sql_enrollments = "SELECT 
          s.student_id,
          s.name AS student_name,
          s.email,
          c.course_id,
          c.course_name,
          c.credits
        FROM enrollments e
        JOIN students s ON e.student_id = s.student_id
        JOIN courses c ON e.course_id = c.course_id";

      $result_enrollments = $conn->query($sql_enrollments);

      if ($result_enrollments->num_rows > 0) {
        while ($row = $result_enrollments->fetch_assoc()) {
          echo "<tr>
            <td>" . htmlspecialchars($row["student_id"]) . "</td>
            <td>" . htmlspecialchars($row["student_name"]) . "</td>
            <td>" . htmlspecialchars($row["email"]) . "</td>
            <td>" . htmlspecialchars($row["course_name"]) . "</td>
            <td>" . htmlspecialchars($row["credits"]) . "</td>
            <td>
              <form action='library/sql/unenroll.php' method='POST' onsubmit='return confirm(\"Unenroll this student from the course?\")'>
                <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                <input type='hidden' name='course_id' value='" . $row["course_id"] . "'>
                <button type='submit' class='btn btn-warning btn-sm'>Unenroll</button>
              </form>
            </td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No enrollments found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</div>

</body>
</html>
