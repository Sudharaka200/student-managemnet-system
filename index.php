<?php
//Db connection
include 'library/db.php';

//Select Students from studnts table
$sql = "SELECT student_id, email FROM students";
$result = $conn->query($sql);

//Select Courses From Course Table
$sql1 = "SELECT course_id, course_name FROM courses";
$result1  = $conn->query($sql1);


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- boostrap -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- add students -->
    <div class="container">
        <h1 class="text-center mt-5">Student Management System</h1>
        <div class="p-20">
            <form action="library/sql/students.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" class="form-control" name="student_name" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" name="student_email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                    <input type="number" class="form-control" name="student_phone" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- add courses -->
    <div class="container">
        <h1 class="text-center mt-5">Courses</h1>
        <div class="p-20">
            <form action="library/sql/courses.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Course Name</label>
                    <input type="text" class="form-control" name="course_name" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">credits</label>
                    <input type="number" class="form-control" name="credits" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- add student to course -->
    <div class="container">
        <h1 class="text-center mt-5">Add Students to course</h1>
        <div class="p-20">
            <form action="library/sql/enrollment.php" method="POST">
                <div class="mb-3">
                    <label for="employeeSelect" class="form-label">Select Students</label>
                    <select class="form-select" id="employeeSelect">
                        <option selected disabled>Choose...</option>
                        <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["student_id"] . '">' . htmlspecialchars($row["email"]) . '</option>';
                        }
                    } else {
                        echo '<option disabled>No students found</option>';
                    }
                    ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="employeeSelect" class="form-label">Select Course</label>
                    <select class="form-select" id="employeeSelect">
                        <option selected disabled>Choose...</option>
                       <?php
                    if ($result1->num_rows > 0) {
                        while ($row = $result1->fetch_assoc()) {
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


</body>

</html>