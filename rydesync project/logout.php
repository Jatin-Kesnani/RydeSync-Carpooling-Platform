<?php
// Start the session and get the data
session_start();
session_unset();
session_destroy();
echo '<script>alert("you have been logged out!")</script>';
header('location: ./login.php');
?>
