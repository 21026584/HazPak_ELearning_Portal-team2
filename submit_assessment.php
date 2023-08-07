<?php
// Check user session
include("checkSession.php");

// Check if the user is logged in and retrieve their user ID
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    // If the user is not logged in, you might want to handle this situation accordingly
    echo "User not logged in.";
    exit; // Stop further processing if the user is not logged in
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include necessary files and database connection
    include("dbFunctions.php");

    // Retrieve the assessment ID from the form
    $assessmentId = $_POST['assessment_id'];

    // Get the included question IDs for the assessment
    $includedQuestionIds = array();
    $query = "SELECT questions FROM assessments WHERE assessment_id = '$assessmentId'";
    $result = mysqli_query($link, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $includedQuestionIds = json_decode($row['questions'], true);
    }

    // Retrieve the arrays of question IDs and user answers from the form
    $questionIds = $_POST['question_ids'];
    $userAnswers = $_POST;

    // Initialize variables for tracking correct answers and total questions
    $correctAnswers = array();
    $totalQuestions = count($includedQuestionIds);

    // Loop through included question IDs and compare with user answers
    foreach ($includedQuestionIds as $questionId) {
        $userAnswerKey = "question_" . $questionId;
    
        if (isset($userAnswers[$userAnswerKey])) {
            $userAnswer = $userAnswers[$userAnswerKey];
    
            // Retrieve the correct answer and question text from the question_bank table
            $query = "SELECT question_answer, question_text FROM question_bank WHERE question_id = '$questionId'";
            $result = mysqli_query($link, $query);
    
            if ($row = mysqli_fetch_assoc($result)) {
                $correctAnswerJson = $row['question_answer'];
                $questionText = $row['question_text'];
    
                // Decode the correct answer from JSON format
                $correctAnswerArray = json_decode($correctAnswerJson, true);
                $correctAnswer = implode(", ", $correctAnswerArray);
    
                // Compare user's answer to the correct answer
                if ($userAnswer === $correctAnswer) {
                    $correctAnswers[] = $questionId; // Store correct question IDs
                }
    
                // Echo question text, correct answer, and user's answer
                echo "Question: " . $questionText . "<br>";
                echo "Correct Answer: " . $correctAnswer . "<br>";
                echo "Your Answer: " . $userAnswer . "<br><br>";
            }
        }
    }
    
    

    // Calculate the user's score
    $userScore = count($correctAnswers);

    // Retrieve user and assessment details
    $userId = $_SESSION['user_id']; // Change to actual session variable
    $courseId = $_POST['courseId'];

    $timeTaken = $_POST['time_taken']; // Get the time_taken from the form

    $adjustedDurationInSeconds = max($timeTaken, 0);
    // Convert the adjusted duration back to time format
    $adjustedDurationTime = gmdate("H:i:s", $adjustedDurationInSeconds);
    
    // Insert user's grade and adjusted duration into assessment_grade table
    $insertQuery = "INSERT INTO assessment_grade (assessment_id, course_id, user_id, score, time_taken) 
                    VALUES ('$assessmentId', '$courseId', '$userId', '$userScore', '$adjustedDurationTime')";
    mysqli_query($link, $insertQuery);

    // Display the user's score
    echo "Your score: " . $userScore . " out of " . $totalQuestions . "<br>";

    // Display the questions that were answered correctly
    echo "Questions you got correct:<br>";
    foreach ($correctAnswers as $questionId) {
        $query = "SELECT question_text FROM question_bank WHERE question_id = '$questionId'";
        $result = mysqli_query($link, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            echo "- " . $row['question_text'] . "<br>";
        }
    }

    // Close the database connection
    mysqli_close($link);
}
?>
