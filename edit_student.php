<?php
include 'library/db.php';

// Check if student_id is set in the query string
if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    echo "<script>alert('No student ID provided.'); window.location.href='index.php';</script>";
    exit();
}

$student_id = intval($_GET['student_id']);

// Fetch student details
$stmt = $conn->prepare("SELECT name, email, phone FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Student not found.'); window.location.href='index.php';</script>";
    exit();
}

$student = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form action="library/update_student.php" method="POST">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
