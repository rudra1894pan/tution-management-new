<?php
$conn = new mysqli("localhost", "root", "", "tution_new_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>