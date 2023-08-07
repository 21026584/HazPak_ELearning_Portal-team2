<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

$exerciseID = $_GET['exercise_id'];

//build a query to delete a specific record based on id
$queryDelete = "DELETE FROM exercises WHERE exercise_id=$exerciseID";

$status =mysqli_query($link, $queryDelete) or die(mysqli_error($link));
//if statement to check whether the delete is successful
//store the success or error message into variable $message
if($status){
    $message="Exercise has been deleted.";
} else {
    $message="Exercise delete failed";
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="stylesheets/style.css" rel="stylesheet" type="text/css"/>
        <title>Exercise Delete</title>
    </head>
    <body>
        <?php include "navbar.php" ?>
        <h3>Exercise - Delete</h3>
        <?php
        echo $message;
        ?>
        <p><a href="exercises.php" class="custom-nav-link">Return</a> to exercise table?</p>
    </body>
</html>