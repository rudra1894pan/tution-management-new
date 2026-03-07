<?php
session_start();
include('../admin/db.php');
// Fetch students belonging to batches taught by this teacher
$t_id = $_SESSION['user_id']; // You'll need to store user_id in session during login
$sql = "SELECT users.username, batches.batch_name 
        FROM student_details 
        JOIN users ON student_details.user_id = users.id 
        JOIN batches ON student_details.batch_id = batches.batch_id 
        WHERE batches.teacher_id = '$t_id'";
$result = $conn->query($sql);
?>