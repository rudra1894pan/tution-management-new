<?php
session_start();
include('admin/db.php'); // Make sure this path points to your connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $role = $_POST['role'];

    // Query to check username, password, and the selected role
    $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($role == 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($role == 'teacher') {
            header("Location: teacher/dashboard.php");
        } elseif ($role == 'student') {
            header("Location: student/dashboard.php");
        }
    } else {
        echo "<script>alert('Invalid Credentials or Role'); window.location='index.php';</script>";
    }
}
?>