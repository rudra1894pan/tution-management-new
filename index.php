<form action="login_process.php" method="POST" autocomplete="off">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter Username" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>
    </div>

    <div class="form-group">
        <label>Login As:</label>
        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>
    </div>

    <button type="submit" class="login-btn">Login to Dashboard</button>
</form>