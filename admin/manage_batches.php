<?php
session_start();
include('db.php');

// Security: Admin only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batch_name = mysqli_real_escape_string($conn, $_POST['batch_name']);
    $teacher_id = $_POST['teacher_id'];
    $fees = $_POST['fees'];
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);

    $sql = "INSERT INTO batches (batch_name, teacher_id, fees, schedule) 
            VALUES ('$batch_name', '$teacher_id', '$fees', '$schedule')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Batch Created!'); window.location='manage_batches.php';</script>";
    }
}

// Fetch Teachers for the dropdown
$teachers = $conn->query("SELECT id, username FROM users WHERE role='teacher'");

// Fetch all Batches to display in a table
$batch_list = $conn->query("SELECT b.*, u.username as teacher_name 
                           FROM batches b 
                           LEFT JOIN users u ON b.teacher_id = u.id");
?>

<h2>Manage Batches</h2>

<form method="POST" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
    <h3>Create New Batch</h3>
    <input type="text" name="batch_name" placeholder="Batch Name (e.g. Java Morning)" required><br><br>
    
    <select name="teacher_id" required>
        <option value="">Assign Teacher</option>
        <?php while($t = $teachers->fetch_assoc()): ?>
            <option value="<?php echo $t['id']; ?>"><?php echo $t['username']; ?></option>
        <?php endwhile; ?>
    </select><br><br>
    
    <input type="number" name="fees" placeholder="Monthly Fees" required><br><br>
    <input type="text" name="schedule" placeholder="Schedule (e.g. Mon-Fri 10AM)" required><br><br>
    <button type="submit">Create Batch</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>Batch Name</th>
        <th>Teacher</th>
        <th>Fees</th>
        <th>Schedule</th>
    </tr>
    <?php while($row = $batch_list->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['batch_name']; ?></td>
        <td><?php echo $row['teacher_name']; ?></td>
        <td>₹<?php echo $row['fees']; ?></td>
        <td><?php echo $row['schedule']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="dashboard.php">Back to Dashboard</a>