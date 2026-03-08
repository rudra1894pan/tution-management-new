<?php
session_start();
include('../admin/db.php');

// 1. Get the Batch ID from the URL
if (!isset($_GET['batch_id'])) {
    echo "<script>alert('No Batch Selected!'); window.location='attendance_logs.php';</script>";
    exit();
}

$batch_id = $_GET['batch_id'];

// 2. Fetch the Batch Name for the heading
$batch_info = $conn->query("SELECT batch_name FROM batches WHERE batch_id = '$batch_id'")->fetch_assoc();

// 3. Fetch all attendance records for this batch
$query = "SELECT a.date, u.username as student_name, a.status 
          FROM attendance a
          JOIN users u ON a.student_id = u.id
          WHERE a.batch_id = '$batch_id'
          ORDER BY a.date DESC";
$results = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance History - <?php echo $batch_info['batch_name']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-present { color: green; font-weight: bold; }
        .status-absent { color: red; font-weight: bold; }
        .back-btn { text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

    <a href="attendance_logs.php" class="back-btn">← Back to Batch Selection</a>
    <h2>Attendance History: <?php echo $batch_info['batch_name']; ?></h2>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if($results->num_rows > 0): ?>
                <?php while($row = $results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d-M-Y', strtotime($row['date'])); ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td class="<?php echo ($row['status'] == 'Present') ? 'status-present' : 'status-absent'; ?>">
                        <?php echo $row['status']; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No records found for this batch.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>