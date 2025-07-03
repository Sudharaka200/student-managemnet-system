<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
        $student_id = intval($_POST['student_id']);
        $course_id = intval($_POST['course_id']);

        // Check if students in the course
        $studentCheck = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
        $studentCheck->bind_param("i", $student_id);
        $studentCheck->execute();
        $studentResult = $studentCheck->get_result();

        if ($studentResult->num_rows === 0) {
            echo "<script>alert('Student does not exist!'); window.history.back();</script>";
            exit();
        }

        // Check if courses in the students
        $courseCheck = $conn->prepare("SELECT course_id FROM courses WHERE course_id = ?");
        $courseCheck->bind_param("i", $course_id);
        $courseCheck->execute();
        $courseResult = $courseCheck->get_result();

        if ($courseResult->num_rows === 0) {
            echo "<script>alert('Course does not exist!'); window.history.back();</script>";
            exit();
        }

        // Check if already enrolled
        $check = $conn->prepare("SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?");
        $check->bind_param("ii", $student_id, $course_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Student is already enrolled in this course!'); window.history.back();</script>";
        } else {
            // Check number of enrolled courses
            $countQuery = $conn->prepare("SELECT COUNT(*) as total FROM enrollments WHERE student_id = ?");
            $countQuery->bind_param("i", $student_id);
            $countQuery->execute();
            $countResult = $countQuery->get_result();
            $row = $countResult->fetch_assoc();
            $totalEnrolled = $row['total'];

            if ($totalEnrolled >= 3) {
                echo "<script>alert('Student cannot enroll in more than 3 courses!'); window.history.back();</script>";
            } else {
                // Proceed to enroll
                $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $student_id, $course_id);

                if ($stmt->execute()) {
                    echo "<script>alert('Student enrolled successfully!'); window.location.href='../../index.php';</script>";
                } else {
                    $error = $stmt->error;
                    echo "<script>alert('Error enrolling student: $error'); window.history.back();</script>";
                }

                $stmt->close();
            }

            $countQuery->close();
        }

        $check->close();
        $studentCheck->close();
        $courseCheck->close();
        $conn->close();
    } else {
        echo "<script>alert('Missing student or course ID.'); window.history.back();</script>";
    }
}
?>
