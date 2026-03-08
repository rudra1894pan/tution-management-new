<?php
session_start();
include('../admin/db.php');

// 1. Security Check: Only Teachers
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../index.php");
    exit();
}

// 2. Fix the "Undefined Key" Error: Check if batch_id exists
if (!isset($_GET['batch_id'])) {
    echo "<script>alert('No Batch Selected!'); window.location='dashboard.php';</script>";
    exit();
}

$batch_id = $_GET['batch_id']; 

// 3. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date('Y-m-d');
    
    foreach ($_POST['attendance'] as $student_id => $status) {
        $sql = "INSERT INTO attendance (student_id, batch_id, date, status) 
                VALUES ('$student_id', '$batch_id', '$date', '$status')";
        $conn->query($sql);
    }
    echo "<script>alert('Attendance submitted successfully!'); window.location='dashboard.php';</script>";
}

// 4. Fetch students for the table
$student_list = $conn->query("SELECT u.id, u.username FROM users u 
                              JOIN student_details sd ON u.id = sd.user_id 
                              WHERE sd.batch_id = '$batch_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 50%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .submit-btn { background-color: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; }
        .submit-btn:hover { background-color: #218838; }
    </style>
</head>
<body>

<h2>Mark Attendance for Batch #<?php echo htmlspecialchars($batch_id); ?></h2>
<a href="dashboard.php">← Back to Dashboard</a>

<form method="POST">
    <table>
        <tr>
            <th>Student Name</th>
            <th>Present</th>
            <th>Absent</th>
        </tr>
        <?php while($s = $student_list->fetch_assoc()): ?>
        <tr>
            <td><?php echo $s['username']; ?></td>
            <td><input type="radio" name="attendance[<?php echo $s['id']; ?>]" value="Present" checked></td>
            <td><input type="radio" name="attendance[<?php echo $s['id']; ?>]" value="Absent"></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <button type="submit" class="submit-btn">Save Attendance Records</button>
</form>

</body>
</html>