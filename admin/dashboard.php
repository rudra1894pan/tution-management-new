<?php
session_start();
include('db.php');

// Security: Kick out anyone who is not an Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Fetch counts for the dashboard cards
$teacher_count = $conn->query("SELECT id FROM users WHERE role='teacher'")->num_rows;
$student_count = $conn->query("SELECT id FROM users WHERE role='student'")->num_rows;
$batch_count = $conn->query("SELECT batch_id FROM batches")->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        .card { display: inline-block; padding: 20px; margin: 10px; border-radius: 8px; color: #333; font-weight: bold; width: 120px; text-align: center; }
        .blue { background-color: #add8e6; }
        .green { background-color: #90ee90; }
        .yellow { background-color: #ffffe0; border: 1px solid #ddd; }
        .menu a { display: block; margin: 10px 0; text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <div style="display: flex;">
        <div class="menu" style="width: 200px; border-right: 1px solid #ccc; height: 100vh; padding: 10px;">
            <h3>Admin Menu</h3>
            <a href="dashboard.php">Dashboard</a>
            <a href="add_teacher.php">Add Teacher</a>
            <a href="add_student.php">Add Student</a>
            <a href="manage_batches.php">Manage Batches</a>
            <a href="../logout.php" style="color: red;">Logout</a>
        </div>

        <div style="padding: 20px; flex-grow: 1;">
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
            
            <div class="card blue">Teachers: <?php echo $teacher_count; ?></div>
            <div class="card green">Students: <?php echo $student_count; ?></div>
            <div class="card yellow">Batches: <?php echo $batch_count; ?></div>
        </div>
    </div>
</body>
</html>