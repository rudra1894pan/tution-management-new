<?php
session_start();
include('db.php'); // Ensure this connects to your tution_new_db

// Security: Ensure only admins can access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $batch_id = $_POST['batch_id'];

    // 1. Insert into users table
    $user_sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'student')";
    
    if ($conn->query($user_sql) === TRUE) {
        $new_user_id = $conn->insert_id; // Get the ID of the user just created

        // 2. Insert into student_details table
        $details_sql = "INSERT INTO student_details (user_id, batch_id) VALUES ('$new_user_id', '$batch_id')";
        
        if ($conn->query($details_sql) === TRUE) {
            echo "<script>alert('Student added successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "Error adding details: " . $conn->error;
        }
    } else {
        echo "Error creating user: " . $conn->error;
    }
}

// Fetch batches for the dropdown menu
$batch_query = "SELECT * FROM batches";
$batch_result = $conn->query($batch_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Enroll New Student</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="text" name="password" placeholder="Password" required><br><br>
        
        <select name="batch_id" required>
            <option value="">Select Batch</option>
            <?php while($row = $batch_result->fetch_assoc()): ?>
                <option value="<?php echo $row['batch_id']; ?>"><?php echo $row['batch_name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>
        
        <button type="submit">Add Student</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>