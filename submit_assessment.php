<?php
// Include database connection
include("dbFunctions.php");

// Assuming the form data is posted and you have access to the $_POST array
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the assessment ID from the form data (you need to adjust this depending on your form)
    $assessmentId = $_POST['assessment_id'];

    // Initialize an array to store responses
    $responses = array();

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            $questionId = substr($key, strlen('question_'));
            $responses[$questionId] = intval($value); // Convert the value to an integer (option index)
        }
    }

    // Convert the responses array to JSON format
    $responsesJSON = json_encode($responses);

    // Store the responses in the database
    $updateQuery = "UPDATE assessments SET user_responses = '$responsesJSON' WHERE assessment_id = '$assessmentId'";
    $updateResult = mysqli_query($link, $updateQuery) or die(mysqli_error($link));

    // You can perform other actions or display a success message here
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Assessment Submitted</title>
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="container mt-4">
        <h2>Assessment Submitted</h2>
        <p>Your responses have been successfully submitted. Thank you!</p>
        <!-- You can include additional information or links as needed -->
    </div>

    <script src="script.js"></script>
</body>
</html>
