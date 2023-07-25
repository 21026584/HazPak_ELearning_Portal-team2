<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";


if (!empty($_POST['name']) && !empty($_POST['instruction']) && !empty($_POST['time']) && !empty($_POST['inputQuestion'])) {
    //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
    $name = $_POST['name'];
    $instructions = $_POST['instruction'];
    $time = $_POST['time'];
    $userID = $_SESSION['user_id'];
    $questions = $_POST['inputQuestion'];
    $question_JSON = json_encode($questions);

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
        $stmt = $conn->prepare("INSERT INTO assessments (assessment_name, instructions, release_datetime, user_id, questions) VALUES (:value1, :value2, :foreign_key)");
    
        // Bind parameters
        $name = $_POST['name'];
        $instructions = $_POST['instruction'];
        $time = $_POST['time'];
        $questions = $_POST['inputQuestion'];
        $question_JSON = json_encode($questions);
        $stmt->bindParam(':value1', $value1);
        $stmt->bindParam(':value2', $value2);
        $stmt->bindParam(':foreign_key', $foreign_key_value);
    
        // Execute the query
        $stmt->execute();
    
        echo "New row inserted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $question_JSON = json_encode($questions);

    //unclear about the assessment id and course id for now.
    $sql = "INSERT INTO assessments (assessment_name, instructions, release_datetime, user_id, questions) 
                VALUES ('$name', '$instructions', '$time', '$userID', '$question_JSON')";

    // Executes the SQL statement above to input it into database
    $status = mysqli_query($link, $sql) or die(mysqli_error($link));

    if ($status == TRUE) {
        $message = "Assessment created successfully.";
    } else {
        $message = "Assessment created failed.";
    }
} else {
    $message = "All Assessment details have to be provided. <a href='createAssessment.php'>Return</a>";
}

// Closes the Database conection 
mysqli_close($link);
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
    <link rel="stylesheet" href="style.css">
    <title>Create Assessment</title>
</head>

<body>
    <h3>Create Assessment</h3>
    <p>
        <?php echo $message; ?>
    </p>
</body>

</html>