<?php
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

// php file that contains the common database connection code
include "dbFunctions.php";

if (!empty($_POST['name']) && !empty($_POST['instruction']) && !empty($_POST['time']) && !empty($_POST['question'])) {
    //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
    $name = $_POST['name'];
    $instructions = $_POST['instruction'];
    $time = $_POST['time'];
    $questions = $_POST['question'];

    //unclear about the assessment id and course id for now.
    $sql = "INSERT INTO assessments (assessment_name, instructions, release_datetime, user_id, questions) 
                VALUES ('$name', '$instructions', '$time', $userID, '$questions')";

    // Executes the SQL statement above to input it into database
    $status = mysqli_query($link, $sql) or die(mysqli_error($link));

    if ($status) {
        $message = "Assessment created successfully.";
    } else {
        $message = "Assessment created failed.";
    }
} else {
    $message = "All Assessment details have to be provided.";
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
    <h3>Create Assessment</h3>
    <p>
        <?php echo $message; ?>
    </p>
</body>

</html>