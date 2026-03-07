<?php
session_start();
include('db.php');
if(isset($_POST['create_batch'])) {
    $bname = $_POST['b_name'];
    $bfees = $_POST['b_fees'];
    $btime = $_POST['b_time'];
    $sql = "INSERT INTO batches (batch_name, fees, schedule) VALUES ('$bname', '$bfees', '$btime')";
    $conn->query($sql);
}
?>
<h3>Create New Batch</h3>
<form method="POST">
    <input type="text" name="b_name" placeholder="Batch Name (e.g. 10th Maths)" required><br><br>
    <input type="number" name="b_fees" placeholder="Monthly Fees" required><br><br>
    <input type="text" name="b_time" placeholder="Timing (e.g. 4PM - 5PM)" required><br><br>
    <button type="submit" name="create_batch">Create Batch</button>
</form>
<hr>
<h4>Existing Batches</h4>
<?php
$res = $conn->query("SELECT * FROM batches");
while($row = $res->fetch_assoc()) {
    echo $row['batch_name'] . " | " . $row['schedule'] . " | Fees: " . $row['fees'] . "<br>";
}
?>
<br><a href="dashboard.php">Back to Dashboard</a>