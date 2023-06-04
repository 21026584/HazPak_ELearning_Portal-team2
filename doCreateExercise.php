<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
        <title>Create Exercise</title>
    </head>
    <body>
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
            $ExName =$_POST['name'];
            $ExIncstru = $_POST['instruction'];
            $ExTime = $_POST['time'];
            $ExQuestion = $_POST['question'];
        
            //unclear about the assessment id and course id for now.
            $sql = "INSERT INTO exercises (exercise_name, instructions, release_datetime, user_id, questions) 
                    VALUES ('$ExName', '$ExIncstru', '$ExTime', $userID, '$ExQuestion')";
            
            // Executes the SQL statement above to input it into database
            $status = mysqli_query($link, $sql) or die(mysqli_error($link));
            
            if ($status) {
                $message = "Exercise created successfully.";
            } else {
                $message = "Exercise created failed.";
            }
        } else {
                $message = "All Exercise details have to be provided.";
        }
        
        // Closes the Database conection 
        mysqli_close($link);
        include "navbar.php" 
        ?>
        <h3>Create Exercise</h3>
        <p>
            <?php echo $message; ?>
        </p>
    </body>
</html>