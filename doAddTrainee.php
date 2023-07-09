<?php

    // Navbar
    include "navbar.php";

    // php file that contains the common database connection code
    include "dbFunctions.php";

    if (!empty($_POST['name']) && !empty($_POST['instruction']) && !empty($_POST['time']) && !empty($_POST['question'])) {
        //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
/*         $name = $_POST['name'];
        $instructions = $_POST['instruction'];
        $time = $_POST['time'];
        $questions = $_POST['question']; */

        //unclear about the assessment id and course id for now.
        $sql = "INSERT INTO users (user_id, instructions, release_datetime, user_id, questions) 
                VALUES ('$id', '$instructions', '$time', $userID, '$questions')";

        // Executes the SQL statement above to input it into database
        $status = mysqli_query($link, $sql) or die(mysqli_error($link));

        if ($status) {
            $message = "Trainee added successfully.";
        } else {
            $message = "Failed to add trainee.";
        }
    } else {
            $message = "All trainee details have to be provided.";
    }

    // Closes the Database conection 
    mysqli_close($link);
?>