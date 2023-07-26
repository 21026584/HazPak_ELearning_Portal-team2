<?php
// Check user session
//include("checkSession.php");
// php file that contains the common database connection code
include "dbFunctions.php";

// Retrieve the selected assessment ID from the URL
// $assessmentId = $_GET['assessment_id'];
$assessmentId = 0;

// Query to fetch assessment details based on the ID
$query = "SELECT A.assessment_name, A.release_datetime, A.questions
FROM assessments AS A
WHERE assessment_id = '$assessmentId'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Query to fetch question details
$query = "SELECT *
FROM question_bank AS QB
ORDER BY question_type_id ASC";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
?>

<!DOCTYPE html>
<html>

<head>
   <title>[Assessment Name]</title>
</head>

<body>

   <script>
      
   </script>
</body>

</html>