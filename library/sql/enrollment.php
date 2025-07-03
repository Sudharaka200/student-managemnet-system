<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
        $student_id = intval($_POST['student_id']);
        $course_id = intval($_POST['course_id']);

        $check = $conn->prepare("SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?");
        $check->bind_param("ii", $student_id, $course_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Student is already enrolled in this course!'); window.history.back();</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $student_id, $course_id);

            if ($stmt->execute()) {
                echo "<script>alert('Student enrolled successfully!'); window.location.href='../../index.php';</script>";
            } else {
                echo "<script>alert('Error enrolling student'); window.history.back();</script>";
            }

            $stmt->close();
        }

        $check->close();
        $conn->close();
    } else {
        echo "<script>alert('Missing student or course ID.'); window.history.back();</script>";
    }
}
?>
