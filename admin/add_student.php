<?php
session_start();
include('db.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['add_student'])) {
    $s_name = $_POST['s_name'];
    $s_pass = $_POST['s_pass'];
    $s_batch = $_POST['s_batch'];

    // 1. Add to universal users table for login
    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$s_name', '$s_pass', 'student')";
    
    if($conn->query($sql_user)) {
        $student_id = $conn->insert_id;
        // 2. Link student to their batch in a student_details table
        // Ensure you have a 'student_details' table with student_id and batch_id
        $sql_detail = "INSERT INTO student_details (user_id, batch_id) VALUES ('$student_id', '$s_batch')";
        $conn->query($sql_detail);
        echo "<script>alert('Student Enrolled Successfully');</script>";
    }
}
?>
<h3>Enroll New Student</h3>
<form method="POST">
    <input type="text" name="s_name" placeholder="Student Username" required><br><br>
    <input type="password" name="s_pass" placeholder="Create Password" required><br><br>
    
    <label>Select Batch:</label><br>
    <select name="s_batch" required>
        <?php
        $batches = $conn->query("SELECT * FROM batches");
        while($b = $batches->fetch_assoc()) {
            echo "<option value='".$b['batch_id']."'>".$b['batch_name']." (Fees: ".$b['fees'].")</option>";
        }
        ?>
    </select><br><br>
    
    <button type="submit" name="add_student">Enroll Student</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>