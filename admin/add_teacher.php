<?php
session_start();
include('db.php');
if(isset($_POST['add_teacher'])) {
    $name = $_POST['t_name'];
    $pass = $_POST['t_pass'];
    // Insert into the universal users table with 'teacher' role
    $sql = "INSERT INTO users (username, password, role) VALUES ('$name', '$pass', 'teacher')";
    if($conn->query($sql)) { echo "<script>alert('Teacher Added Successfully');</script>"; }
}
?>
<h3>Add New Teacher</h3>
<form method="POST">
    <input type="text" name="t_name" placeholder="Teacher Username" required><br><br>
    <input type="password" name="t_pass" placeholder="Assign Password" required><br><br>
    <button type="submit" name="add_teacher">Register Teacher</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>