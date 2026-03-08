<?php
session_start();
include('../admin/db.php');

// Security: Kick out if not a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

$s_id = $_SESSION['user_id'];

// Fetch Student Batch & Teacher Info
$info_sql = "SELECT b.batch_name, b.schedule, u.username as teacher_name 
             FROM student_details sd 
             LEFT JOIN batches b ON sd.batch_id = b.batch_id 
             LEFT JOIN users u ON b.teacher_id = u.id 
             WHERE sd.user_id = '$s_id'";
$info_result = $conn->query($info_sql);
$info = $info_result->fetch_assoc();

// Fetch Attendance Stats
$total_q = $conn->query("SELECT * FROM attendance WHERE student_id = '$s_id'");
$total_days = $total_q->num_rows;

$present_q = $conn->query("SELECT * FROM attendance WHERE student_id = '$s_id' AND status='Present'");
$present_days = $present_q->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 20px; }
        .container { background: white; border: 1px solid #ddd; padding: 20px; border-radius: 8px; max-width: 600px; }
        .section { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .stat-box { display: inline-block; background: #f0f0f0; padding: 10px; border-radius: 5px; margin-right: 10px; }
        .present { color: green; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <a href="../logout.php" style="color:red;">Logout</a>

        <div class="section">
            <h3>My Batch Info</h3>
            <p><b>Batch:</b> <?php echo $info['batch_name'] ?? 'Not Assigned'; ?></p>
            <p><b>Teacher:</b> <?php echo $info['teacher_name'] ?? 'N/A'; ?></p>
            <p><b>Timing:</b> <?php echo $info['schedule'] ?? 'N/A'; ?></p>
        </div>

        <div class="section">
            <h3>Attendance Summary</h3>
            <div class="stat-box">Total Classes: <?php echo $total_days; ?></div>
            <div class="stat-box">Days Present: <span class="present"><?php echo $present_days; ?></span></div>
        </div>
    </div>

</body>
</html>