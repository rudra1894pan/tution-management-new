<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') { // Change 'admin' to 'teacher' or 'student' for those folders
    header("Location: ../index.php");
    exit();
}
?>
<h1>Welcome to the Admin Dashboard, <?php echo $_SESSION['username']; ?></h1>
<a href="../logout.php">Logout</a>