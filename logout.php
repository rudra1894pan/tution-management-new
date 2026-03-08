<?php
session_start();
session_unset(); // Removes all session variables
session_destroy(); // Destroys the session on the server

// Prevent back button caching
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

header("Location: index.php"); // Redirect to login page
exit();
?>