<?php
session_start();
include('db.php');
// Check Admin Session
?>
<h3>Monthly Fee Collection Report</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Date</th>
        <th>Student Name</th>
        <th>Amount</th>
        <th>Month For</th>
        <th>Mode</th>
    </tr>
    <?php
    $sql = "SELECT p.*, u.username FROM payments p JOIN users u ON p.student_id = u.id ORDER BY p.payment_date DESC";
    $report = $conn->query($sql);
    while($row = $report->fetch_assoc()) {
        echo "<tr>
                <td>{$row['payment_date']}</td>
                <td>{$row['username']}</td>
                <td>₹{$row['amount_paid']}</td>
                <td>{$row['month_for']}</td>
                <td>{$row['payment_mode']}</td>
              </tr>";
    }
    ?>
</table>
<br><a href="dashboard.php">Back to Dashboard</a>