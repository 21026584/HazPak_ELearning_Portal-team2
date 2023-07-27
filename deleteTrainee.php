<?php
// deleteTrainee.php
include("dbFunctions.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Log the user_id to error log (for debugging purposes)
    error_log('User ID to delete: ' . $user_id);

    // Check if there are any related records in the "grades" table for the user
    $stmt = mysqli_prepare($link, "SELECT * FROM grades WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // If there are related records in the "grades" table, delete them first
        $deleteGradesStmt = mysqli_prepare($link, "DELETE FROM grades WHERE user_id = ?");
        mysqli_stmt_bind_param($deleteGradesStmt, "s", $user_id);
        mysqli_stmt_execute($deleteGradesStmt);
        mysqli_stmt_close($deleteGradesStmt);
    }

    // Now, proceed with the deletion of the user from the "users" table
    $deleteUserStmt = mysqli_prepare($link, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($deleteUserStmt, "s", $user_id); // Use "s" for string type (varchar)
    $result = mysqli_stmt_execute($deleteUserStmt);

    // Handle deletion success or failure
    if ($result) {
        // Deletion successful
        mysqli_stmt_close($deleteUserStmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        header("Location: courses.php"); // Redirect back to courses.php after successful deletion
        exit;
    } else {
        // Deletion failed
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete trainee.'));
    }

    // Close the prepared statements and database connection
    mysqli_stmt_close($deleteUserStmt);
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
