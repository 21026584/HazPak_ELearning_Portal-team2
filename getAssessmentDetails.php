<?php
// Include database connection
include("dbFunctions.php");

// Retrieve the selected assessment ID from the AJAX request
$assessmentId = $_POST['assessmentId'];

// Query to fetch assessment details based on the ID
$query = "SELECT A.assessment_name, A.instructions, A.release_datetime, U.username
FROM assessments AS A
INNER JOIN users AS U
ON U.user_id = A.user_id
WHERE assessment_id = '$assessmentId'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Generate the HTML content based on the fetched data
if ($row = mysqli_fetch_assoc($result)) {
    $assessmentName = $row['assessment_name'];
    $createdBy = $row['username'];
    $instructions = $row['instructions'];
    $releaseTime = $row['release_datetime'];

    // Generate the updated content with the fetched data
    $updatedContent = '
            <div class="assessment-details-header">
                ' . $assessmentName . '
            </div>
            <div class="assessment-details-body">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        Start Time: ' . $releaseTime . '
                    </div>
                    <div>
                        Time Taken: -
                    </div>
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
                    <a href="takeAssessment.php?assessment_id=' . $assessmentId . '" class="start-assessment-button">Start</a>
                </div>
            </div>';

    // Return the updated content as the AJAX response
    echo $updatedContent;
} else {
    // In case the assessment ID is not found or an error occurs, you can return an error message or default content
    echo '<div class="assessment-details-header">Assessment Details Not Found, ID: ' . $assessmentId . '</div>';
}

// Close the database connection
mysqli_close($link);
