<?php
session_start();
include('admin/db.php'); // Shared connection

$user = $_POST['username'];
$pass = $_POST['password'];
$role = $_POST['role'];

$sql = "SELECT * FROM users WHERE username='$user' AND password='$pass' AND role='$role'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['user'] = $user;
    $_SESSION['role'] = $role;
    header("Location: $role/dashboard.php"); // Automatically goes to the right folder!
} else {
    echo "Invalid Login Credentials";
}
?>