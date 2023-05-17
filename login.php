<?php
// Database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "mydatabase";

// Retrieve form data
$enteredUsername = $_POST['username'];
$enteredPassword = $_POST['password'];

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database for the entered credentials
$query = "SELECT * FROM users WHERE username='$enteredUsername' AND password='$enteredPassword'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Valid login credentials
    // Start a session or set cookies to maintain login status
    // Redirect to the dashboard page
    header("Location: dashboard.html");
} else {
    // Invalid login credentials
    echo "Invalid username or password.";
}

$conn->close();
?>