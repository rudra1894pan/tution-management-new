<?php
session_start();
include('admin/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic sanitization to prevent breaking the SQL string
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // This is the specific line that was failing; rewritten for maximum compatibility
    $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND role = '$role' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        header("Location: " . $row['role'] . "/dashboard.php");
        exit();
    } else {
        echo "<script>alert('Login Failed: Check Username/Password/Role'); window.location='index.php';</script>";
    }
}
?>