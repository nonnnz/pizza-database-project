<?php
session_start();
// Include the database connection file

if (isset($_SESSION['user_id'])) {
  // Unset all session variables
  $_SESSION = array();

  // Destroy the session
  session_destroy();
}

header("Location: home.php");
?>