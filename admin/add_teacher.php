<?php
session_start();
include('db.php');

// Security: Ensure only Admin can access this page
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['add_teacher'])) {
    $name = $_POST['t_name'];
    $raw_pass = $_POST['t_pass'];
    
    // 1. Secure the password using modern hashing
    $hashed_pass = password_hash($raw_pass, PASSWORD_DEFAULT);
    
    // 2. Use Prepared Statements to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'teacher')");
    $stmt->bind_param("ss", $name, $hashed_pass);
    
    if($stmt->execute()) { 
        echo "<script>alert('Teacher Registered Securely!');</script>"; 
    } else {
        echo "<script>alert('Error: Username might already exist');</script>";
    }
    $stmt->close();
}
?>

<h3>Register New Teacher (Secure)</h3>
<form method="POST">
    <input type="text" name="t_name" placeholder="Teacher Username" required><br><br>
    <input type="password" name="t_pass" placeholder="Assign Secure Password" required><br><br>
    <button type="submit" name="add_teacher">Register Teacher</button>
</form>
<hr>
<a href="dashboard.php">Back to Dashboard</a>