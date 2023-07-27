<?php
// deleteTrainee.php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    include("dbFunctions.php"); // Include database connection

    // Prepare and execute the deletion query using prepared statement
    $stmt = mysqli_prepare($link, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $user_id); // "s" indicates string type for user_id
    $result = mysqli_stmt_execute($stmt);

    // Handle deletion success or failure
    if ($result) {
        // Deletion successful
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        header("Location: courses.php"); // Redirect back to courses.php after successful deletion
        exit;
    } else {
        // Deletion failed
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete trainee.'));
    }
    
    // Close the prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
