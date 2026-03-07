<?php include('db.php'); ?>
<form method="POST" action="login_process.php">
    <h2>Admin Login</h2>
    <input type="text" name="user" placeholder="Username" required><br>
    <input type="password" name="pass" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>