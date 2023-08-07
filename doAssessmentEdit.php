<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

// Check if post from assessmentEdit page else bring back to assessmentEdit page
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    try {
        $assessment_id = $_POST['idAssessment']; 
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE assessments SET course_id = :value0, assessment_name = :value1, instructions = :value2, release_datetime = :value3, end_time = :value4, questions = :value5 WHERE assessment_id = :assessment_id");
        
        // Bind parameters
        $name = $_POST['name'];
        $instructions = $_POST['instruction'];
        $time = $_POST['time'];
        $end = $_POST['endTime'];
        $course = $_POST['idCourse'];
        $questions = $_POST['inputQuestion'];
        $question_JSON = json_encode($questions);
        $stmt->bindParam(':value0', $course);
        $stmt->bindParam(':value1', $name);
        $stmt->bindParam(':value2', $instructions);
        $stmt->bindParam(':value3', $time);
        $stmt->bindParam(':value4', $end);
        $stmt->bindParam(':value5', $question_JSON);
        $stmt->bindParam(':assessment_id', $assessment_id);
        
        // Execute the query
        $stmt->execute();
        
        echo "Assessment updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // header("Location: changePassword.php");
    // exit;
    echo "There is an error with the post form inputs";
    header("Location: assessmentEdit.php");
    exit();
}

// Close database connection
mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Edit Assessment</title>
</head>

<body>
<p><a href="assessments.php" class="custom-nav-link">Return</a> to Assessments table</p>
</body>

</html>