<?php
// Start the session
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // If user is not logged in, redirect to the login page
  header("Location: login.php");
  exit;
}
