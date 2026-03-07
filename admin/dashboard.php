<?php
session_start();
include('db.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
// Fetch counts for the cards
$teacher_count = $conn->query("SELECT id FROM users WHERE role='teacher'")->num_rows;
$student_count = $conn->query("SELECT id FROM users WHERE role='student'")->num_rows;
$batch_count = $conn->query("SELECT batch_id FROM batches")->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css"> </head>
<body>
    <div style="display:flex;">
        <div class="sidebar" style="width:200px; background:#f4f4f4; height:100vh; padding:20px;">
            <h3>Admin Menu</h3>
            <p><a href="dashboard.php">Dashboard</a></p>
            <p><a href="add_teacher.php">Add Teacher</a></p>
            <p><a href="manage_batches.php">Manage Batches</a></p>
            <p><a href="../logout.php">Logout</a></p>
        </div>
        <div class="content" style="padding:20px; flex:1;">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            <div style="display:flex; gap:20px;">
                <div style="padding:20px; background:lightblue;">Teachers: <?php echo $teacher_count; ?></div>
                <div style="padding:20px; background:lightgreen;">Students: <?php echo $student_count; ?></div>
                <div style="padding:20px; background:lightyellow;">Batches: <?php echo $batch_count; ?></div>
            </div>
        </div>
    </div>
</body>
</html>