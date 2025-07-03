<?php
//Db connetction
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
        $student_id = intval($_POST['student_id']);
        $course_id = intval($_POST['course_id']);

        // Delete the enrollment
        $stmt = $conn->prepare("DELETE FROM enrollments WHERE student_id = ? AND course_id = ?");
        $stmt->bind_param("ii", $student_id, $course_id);

        if ($stmt->execute()) {
            echo "<script>alert('Student unenrolled successfully.'); window.location.href='../../index.php';</script>";
        } else {
            $error = $stmt->error;
            echo "<script>alert('Error unenrolling student: $error'); window.history.back();</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('Missing student or course ID.'); window.history.back();</script>";
    }
}
?>
