<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php"); // auto redirect to login.php if user is not login in
}

$userID = $_SESSION['user_id'];

// php file that contains the common database connection code
include "dbFunctions.php";

if (!empty($_POST['name']) && !empty($_POST['instruction']) && !empty($_POST['time']) && !empty($_POST['question'])) 
{
    //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
    $AssessName =$_POST['name'];
    $AssessIncstru = $_POST['instruction'];
    $AssessTime = $_POST['time'];
    $AssessQuestion = $_POST['question'];

    //unclear about the assessment id and course id for now.
    $sql = "INSERT INTO assessments (assessment_name, instructions, release_datetime, user_id, questions) 
            VALUES ('$AssessName', '$AssessIncstru', '$AssessTime', $userID, '$AssessQuestion')";
    
    // Executes the SQL statement above to input it into database
    $status = mysqli_query($link, $sql) or die(mysqli_error($link));
    
    if ($status) {
        $message = "Assessment created successfully.";
    } else {
        $message = "Assessment created failed.";
    }
} else {
        $message = "All Item details have to be provided.";
}

// Closes the Database conection 
mysqli_close($link);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
        <title>Create Assessment</title>
    </head>
    <body>
        <?php include "navbar.php" ?>
        <h3>Create Assessment</h3>
        <p>
            <?php echo $message; ?>
        </p>
    </body>
</html>