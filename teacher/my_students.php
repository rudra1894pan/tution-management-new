<?php
session_start();
include('../admin/db.php');

// Security: Teacher only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../index.php");
    exit();
}

$t_id = $_SESSION['user_id'];

// Fetch all students belonging to this teacher's batches
$student_sql = "SELECT u.username as student_name, b.batch_name, b.schedule 
                FROM users u 
                JOIN student_details sd ON u.id = sd.user_id 
                JOIN batches b ON sd.batch_id = b.batch_id 
                WHERE b.teacher_id = '$t_id'
                ORDER BY b.batch_name ASC";

$student_result = $conn->query($student_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Student Directory</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .student-table { width: 100%; border-collapse: collapse; }
        .student-table th, .student-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .student-table th { background-color: #f8f9fa; }
        .back-btn { display: inline-block; margin-bottom: 15px; text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h2>My Student Directory</h2>

    <table class="student-table">
        <tr>
            <th>Student Name</th>
            <th>Enrolled Batch</th>
            <th>Batch Schedule</th>
        </tr>
        <?php if($student_result->num_rows > 0): ?>
            <?php while($row = $student_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['batch_name']; ?></td>
                <td><?php echo $row['schedule']; ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">No students found in your batches.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>