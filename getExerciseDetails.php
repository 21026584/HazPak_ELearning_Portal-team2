<?php
// Include database connection
include("dbFunctions.php");

// Retrieve the selected exercise ID from the AJAX request
$exerciseId = $_POST['exerciseId'];

// Query to fetch exercise details based on the ID
$query = "SELECT E.exercise_name, E.instructions, E.release_datetime, U.username
FROM exercises AS E
INNER JOIN users AS U
ON U.user_id = E.user_id
WHERE exercise_id = '$exerciseId'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Generate the HTML content based on the fetched data
if ($row = mysqli_fetch_assoc($result)) {
    $exerciseName = $row['exercise_name'];
    $createdBy = $row['username'];
    $instructions = $row['instructions'];
    $releaseTime = $row['release_datetime'];

    // Generate the updated content with the fetched data
    $updatedContent = '
            <div class="assessment-details-header">
                ' . $exerciseName . '
            </div>
            <div class="assessment-details-body">
                <div>
                    Start Time: ' . $releaseTime . '
                </div>
                <div style="margin-top: 3em;">
                    Description:
                </div>
                <div style="font-weight: normal;">
                    ' . $instructions . '
                </div>
                <div style="margin-top: 3em;">
                    Created by: ' . $createdBy . '
                </div>
                <div class="assessment-details-button-container">
                    <button class="start-assessment-button">Start</button>
                </div>
            </div>';

    // Return the updated content as the AJAX response
    echo $updatedContent;
} else {
    // In case the exercise ID is not found or an error occurs, you can return an error message or default content
    echo '<div class="assessment-details-header">Exercise Details Not Found, ID: '. $exerciseId . '</div>';
}

// Close the database connection
mysqli_close($link);
