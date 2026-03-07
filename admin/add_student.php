<?php
session_start();
include('db.php');

// Security: Verify Admin access
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST['add_student'])) {
    $s_name = $_POST['s_name'];
    $s_pass = $_POST['s_pass'];
    $s_batch = $_POST['s_batch'];

    // 1. Secure the password
    $hashed_pass = password_hash($s_pass, PASSWORD_DEFAULT);
    
    // 2. Start a transaction (Best practice for multi-table inserts)
    $conn->begin_transaction();

    try {
        // Insert into universal users table
        $stmt1 = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
        $stmt1->bind_param("ss", $s_name, $hashed_pass);
        $stmt1->execute();
        
        $student_id = $conn->insert_id;

        // Insert into student_details table
        $stmt2 = $conn->prepare("INSERT INTO student_details (user_id, batch_id) VALUES (?, ?)");
        $stmt2->bind_param("ii", $student_id, $s_batch);
        $stmt2->execute();

        $conn->commit();
        echo "<script>alert('Student Enrolled Successfully with Secure Password!');</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error enrolling student. Username might be taken.');</script>";
    }
}
?>

<h3>Enroll New Student (Secure)</h3>
<form method="POST">
    <input type="text" name="s_name" placeholder="Student Username" required><br><br>
    <input type="password" name="s_pass" placeholder="Create Secure Password" required><br><br>
    
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
<hr>
<a href="dashboard.php">Back to Dashboard</a>