<?php

    // Navbar
    include "navbar.php";

    // php file that contains the common database connection code
    include "dbFunctions.php";

    if (!empty($_POST['username']) && !empty($_POST['traineeID']) && !empty($_POST['intake'])) {
        //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
       $username = $_POST['username'];
        $id = $_POST['traineeID'];
        $intake = $_POST['intake'];

        //unclear about the assessment id and course id for now.
        $sql = "INSERT INTO users (user_id, username, intake) 
                VALUES ('$id', '$username', '$intake')";

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