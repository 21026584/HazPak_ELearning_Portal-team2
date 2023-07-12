<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");
// Query to fetch assessment details based on the ID
$query = "SELECT A.assessment_name, A.instructions, A.release_datetime, U.username
FROM assessments AS A
INNER JOIN users AS U
ON U.user_id = A.user_id
WHERE assessment_id = '$assessmentId'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

if ($_POST['quType'] > -1) {
    //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
    $selectedType = $_POST['quType'];

    if ($selectedType == 0){
        $msg = "MCQ";
    } else if ($selectedType == 1){
        $msg = "FIB";
    } else if ($selectedType ==2){
        $msg = "Dropdown";
    }
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
    <p>
        <?php 
        echo $msg;
        ?>
    </p>
</body>

</html>