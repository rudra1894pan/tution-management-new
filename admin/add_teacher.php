<?php
session_start();
include('db.php');

// Security: Only allow Admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Insert into users table with the 'teacher' role
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'teacher')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Teacher added successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
</head>
<body>
    <h2>Add New Teacher</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Teacher Name/Username" required><br><br>
        <input type="text" name="password" placeholder="Set Password" required><br><br>
        <button type="submit">Add Teacher</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>