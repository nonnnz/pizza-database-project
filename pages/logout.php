<?php
session_start();
// Include the database connection file

if (isset($_SESSION['email'])) {
  // Unset all session variables
  $_SESSION = array();

  // Destroy the session
  session_destroy();
}

header("Location: /pizza-database-project/home.php");
?>