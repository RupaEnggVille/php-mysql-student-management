<?php
$host = "mysql";
$user = "root";
$password = "root";
$database = "student_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
