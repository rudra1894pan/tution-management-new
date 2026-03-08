<?php
session_start();
include('../admin/db.php');

// Security: Teacher only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../index.php");
    exit();
}

$t_id = $_SESSION['user_id'];
$teacher_name = $_SESSION['username'];

// Fetch batches assigned to this specific teacher
$batches = $conn->query("SELECT * FROM batches WHERE teacher_id = '$t_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Panel</title>
    <style>
        .sidebar { width: 220px; float: left; background: #f4f4f4; height: 100vh; padding: 15px; border-right: 2px solid #ddd; }
        .main-content { margin-left: 250px; padding: 20px; }
        .nav-link { display: block; padding: 10px; text-decoration: none; color: #333; border-bottom: 1px solid #ccc; }
        .nav-link:hover { background: #e0e0e0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-mark { background: #28a745; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>Teacher Menu</h3>
    <p>Welcome, <b><?php echo $teacher_name; ?></b></p>
    <hr>
    <a href="dashboard.php" class="nav-link">🏠 Dashboard</a>
    <a href="my_students.php" class="nav-link">👨‍🎓 My Students</a>
    <a href="attendance_logs.php" class="nav-link">📅 Attendance Logs</a>
    <a href="../logout.php" class="nav-link" style="color:red;">🔒 Logout</a>
</div>

<div class="main-content">
    <h2>My Assigned Batches</h2>
    <table>
        <tr>
            <th>Batch Name</th>
            <th>Schedule</th>
            <th>Fees</th>
            <th>Action</th>
        </tr>
        <?php if($batches->num_rows > 0): ?>
            <?php while($b = $batches->fetch_assoc()): ?>
            <tr>
                <td><?php echo $b['batch_name']; ?></td>
                <td><?php echo $b['schedule']; ?></td>
                <td>₹<?php echo $b['fees']; ?></td>
                <td>
                    <a href="mark_attendance.php?batch_id=<?php echo $b['batch_id']; ?>" class="btn-mark">Mark Attendance</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No batches assigned yet.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>