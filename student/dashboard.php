<?php
session_start();
include('../admin/db.php');

// Security check: Ensure only students can access this folder
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}

$s_id = $_SESSION['user_id'];

// Fetch the student's batch and teacher details
$sql = "SELECT batches.batch_name, batches.schedule, batches.fees, users.username AS teacher_name 
        FROM student_details 
        JOIN batches ON student_details.batch_id = batches.batch_id 
        LEFT JOIN users ON batches.teacher_id = users.id 
        WHERE student_details.user_id = '$s_id'";

$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<h2>Student Portal: <?php echo $_SESSION['username']; ?></h2>
<div style="border: 1px solid #ccc; padding: 15px;">
    <h3>My Batch Details</h3>
    <p><strong>Batch:</strong> <?php echo $data['batch_name']; ?></p>
    <p><strong>Teacher:</strong> <?php echo $data['teacher_name'] ?? 'Not Assigned'; ?></p>
    <p><strong>Schedule:</strong> <?php echo $data['schedule']; ?></p>
    <p><strong>Monthly Fees:</strong> ₹<?php echo $data['fees']; ?></p>
</div>
<br>
<a href="view_attendance.php">View My Attendance History</a> | <a href="../logout.php">Logout</a>