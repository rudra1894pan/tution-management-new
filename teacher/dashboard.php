<?php
session_start();
include('../admin/db.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}
$t_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head><title>Teacher Dashboard</title></head>
<body>
    <h2>Welcome, Teacher: <?php echo $_SESSION['username']; ?></h2>
    <div class="menu">
        <a href="dashboard.php">My Batches</a> | 
        <a href="../logout.php">Logout</a>
    </div>
    <hr>
    <h3>My Assigned Batches</h3>
    <table border="1">
        <tr><th>Batch Name</th><th>Schedule</th><th>Action</th></tr>
        <?php
        $batches = $conn->query("SELECT * FROM batches WHERE teacher_id = '$t_id'");
        while($b = $batches->fetch_assoc()) {
            echo "<tr>
                    <td>".$b['batch_name']."</td>
                    <td>".$b['schedule']."</td>
                    <td><a href='mark_attendance.php?bid=".$b['batch_id']."'>Mark Attendance</a></td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>