<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

$id = $_GET['userid'];

// Build a query to delete a specific record based on username
$queryDelete = "DELETE FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($link, $queryDelete);
mysqli_stmt_bind_param($stmt, "s", $id);

$status = mysqli_stmt_execute($stmt);

// If statement to check whether the delete is successful
// Store the success or error message into the variable $message
if ($status) {
    $message = "Admin has been deleted.";
} else {
    $message = "Admin delete failed";
}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="stylesheets/style.css" rel="stylesheet" type="text/css"/>
    <title>Admin Delete</title>
</head>
<body>
    <h3>Admin - Delete</h3>
    <?php
    echo $message;
    ?>
    <p><a href="admin.php" class="custom-nav-link">Return</a> to Admin table?</p>
</body>
</html>
