<?php
include 'db.php';

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $roll_no = $_POST['roll_no'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $grade = $_POST['grade'];

    $query = "INSERT INTO students(name, roll_no, subject, marks, grade)
              VALUES('$name', '$roll_no', '$subject', '$marks', '$grade')";

    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Student Added Successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Add Student</h1>

    <form method="POST">

        <input type="text" name="name" placeholder="Enter Name" required>

        <input type="text" name="roll_no" placeholder="Enter Roll Number" required>

        <input type="text" name="subject" placeholder="Enter Subject" required>

        <input type="number" name="marks" placeholder="Enter Marks" required>

        <input type="text" name="grade" placeholder="Enter Grade" required>

        <button type="submit" name="submit">Add Student</button>

    </form>

    <br>

    <a href="index.php">Back to Home</a>

</div>

</body>
</html>

