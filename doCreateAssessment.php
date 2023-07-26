<?php
    // php file that contains the common database connection code
    include "dbFunctions.php";
    // Check user session
    include("checkSession.php");
    // Navbar
    include "navbar.php";


    if (!empty($_POST['name']) && !empty($_POST['instruction']) && !empty($_POST['time']) && !empty($_POST['inputQuestion'])&& !empty($_POST['idCourse'])) {
        
        try {
            $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        try {
            // Assume $foreign_key_value is the foreign key value you want to use
            $foreign_key_value = $_SESSION['user_id'];; 
        
            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO assessments (course_id, assessment_name, instructions, release_datetime, user_id, questions) VALUES (:value0, :value1, :value2, :value3, :foreign_key, :value4)");
        
            // Bind parameters
            //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
            $name = $_POST['name'];
            $instructions = $_POST['instruction'];
            $time = $_POST['time'];
            $course = $_POST['idCourse'];
            $userID = $_SESSION['user_id'];
            $questions = $_POST['inputQuestion'];
            $question_JSON = json_encode($questions);
            $stmt->bindParam(':value0', $course);
            $stmt->bindParam(':value1', $name);
            $stmt->bindParam(':value2', $instructions);
            $stmt->bindParam(':value3', $time);
            $stmt->bindParam(':value4', $question_JSON);
            $stmt->bindParam(':foreign_key', $foreign_key_value);
        
            // Execute the query
            $stmt->execute();
        
            echo "Assessment inserted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    // Closes the Database conection 
    mysqli_close($link);
?>
<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Create Assessment</title>
    </head>

    <body>
        <p> Create more <a href="createAssessment.php" class="custom-nav-link">Assessments</a>?</p>
        <p> Return to <a href="assessment.php" class="custom-nav-link">Assessments</a> page?</p>
    </body>

</html>