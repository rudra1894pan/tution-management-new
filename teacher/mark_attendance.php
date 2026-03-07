<?php
session_start();
include('../admin/db.php');
$bid = $_GET['bid']; // Get batch ID from URL

if(isset($_POST['save_attendance'])) {
    foreach($_POST['status'] as $s_id => $stat) {
        $conn->query("INSERT INTO attendance (student_id, batch_id, status) VALUES ('$s_id', '$bid', '$stat')");
    }
    echo "<script>alert('Attendance Saved'); window.location='dashboard.php';</script>";
}
?>
<h3>Mark Attendance for Batch ID: <?php echo $bid; ?></h3>
<form method="POST">
    <table border="1">
        <tr><th>Student Name</th><th>Status</th></tr>
        <?php
        $students = $conn->query("SELECT users.id, users.username FROM student_details JOIN users ON student_details.user_id = users.id WHERE student_details.batch_id = '$bid'");
        while($s = $students->fetch_assoc()) {
            echo "<tr>
                    <td>".$s['username']."</td>
                    <td>
                        <input type='radio' name='status[".$s['id']."]' value='Present' checked> P
                        <input type='radio' name='status[".$s['id']."]' value='Absent'> A
                    </td>
                  </tr>";
        }
        ?>
    </table><br>
    <button type="submit" name="save_attendance">Save Attendance</button>
</form>