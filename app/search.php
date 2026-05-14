<?php
include 'db.php';

$result = null;

if(isset($_POST['search'])) {
    $keyword = $_POST['keyword'];

    $query = "SELECT * FROM students
              WHERE name LIKE '%$keyword%'
              OR roll_no LIKE '%$keyword%'";

    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Search Student</h2>

    <form method="POST" class="search-form">
        <input type="text" name="keyword" placeholder="Enter name or roll number" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php if($result && mysqli_num_rows($result) > 0) { ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Grade</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['roll_no']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['marks']; ?></td>
            <td><?php echo $row['grade']; ?></td>
        </tr>
        <?php } ?>

    </table>

    <?php } elseif($result) { ?>
        <p>No student found.</p>
    <?php } ?>

</div>

</body>
</html>
