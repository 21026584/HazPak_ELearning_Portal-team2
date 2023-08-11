<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

$usrID = $_GET['user_id'];

//build a query to delete a specific record based on id
$queryDelete = "DELETE FROM users WHERE user_id=$usrID";

$status =mysqli_query($link, $queryDelete) or die(mysqli_error($link));
//if statement to check whether the delete is successful
//store the success or error message into variable $message
if($status){
    $message="Admin has been deleted.";
} else {
    $message="Admin delete failed";
}

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
        <?php include "navbar.php" ?>
        <h3>Admin - Delete</h3>
        <?php
        echo $message;
        ?>
        <p><a href="admin.php" class="custom-nav-link">Return</a> to Admin table?</p>
    </body>
</html>