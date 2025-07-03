<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = intval($_POST['student_id']);

    // check enrollemrnt
    $check = $conn->prepare("SELECT * FROM enrollments WHERE student_id = ?");
    $check->bind_param("i", $student_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Cannot delete: student is enrolled in one or more courses. Please unenroll first.'); window.history.back();</script>";
    } else {
        // delete student
        $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);

        if ($stmt->execute()) {
            echo "<script>alert('Student deleted successfully.'); window.location.href='../../index.php';</script>";
        } else {
            echo "<script>alert('Failed to delete student.'); window.history.back();</script>";
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
