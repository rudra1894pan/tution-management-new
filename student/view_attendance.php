<?php
session_start();
include('../admin/db.php');
$s_id = $_SESSION['user_id'];

$attendance = $conn->query("SELECT * FROM attendance WHERE student_id = '$s_id' ORDER BY date DESC");
?>
<h3>My Attendance History</h3>
<table border="1">
    <tr><th>Date</th><th>Status</th></tr>
    <?php while($row = $attendance->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php } ?>
</table>
<br><a href="dashboard.php">Back to Dashboard</a>