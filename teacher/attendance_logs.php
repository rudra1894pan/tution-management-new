<?php
session_start();
include('../admin/db.php');

$t_id = $_SESSION['user_id'];
// Fetch all batches assigned to the logged-in teacher (e.g., Nehal123)
$batches = $conn->query("SELECT * FROM batches WHERE teacher_id = '$t_id'");
?>

<h2>Select a Batch to View Attendance History</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Batch Name</th>
        <th>Schedule</th>
        <th>Action</th>
    </tr>
    <?php while($row = $batches->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['batch_name']; ?></td>
        <td><?php echo $row['schedule']; ?></td>
        <td>
            <a href="view_batch_history.php?batch_id=<?php echo $row['batch_id']; ?>">View Logs</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>