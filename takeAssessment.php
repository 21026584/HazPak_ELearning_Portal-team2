<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");

// Retrieve the selected assessment ID from the URL
$assessmentId = $_GET['assessment_id'];

// Query to fetch assessment details based on the ID
$query = "SELECT A.assessment_name, A.release_datetime, A.questions
FROM assessments AS A
WHERE assessment_id = '$assessmentId'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Retrieve information from the selected assessment role
if ($row = mysqli_fetch_assoc($result)) {
  $assessmentName = $row['assessment_name'];
  $releaseTime = $row['release_datetime'];
  while ($row = $result->fetch_assoc()) {
    // Get the questions column value (JSON string)
    $questionsJSON = $row['questions'];

    // Convert the JSON string to an associative array
    $questionsData = json_decode($questionsJSON, true);

    // Retrieve the question_id values from the JSON array
    $questionIds = array_column($questionsData, 'question_id');

    // Use the question_id values to retrieve data from the question table
    $questionIdsString = implode(',', $questionIds);
  }
  // Execute a SELECT query to fetch data from the question table
  $questionQuery = "SELECT Q.question_name, Q.question_text, Q.question_options, Q.question_type_id
        FROM question as Q
        WHERE question_id
        IN ($questionIdsString)";
  $questionResult = $mysqli->query($questionQuery);

  if ($questionResult) {
    // Fetch each row from the result set
    while ($questionRow = $questionResult->fetch_assoc()) {
      $questionName = $questionRow['question_name'];
      $questionText = $questionRow['question_text'];
      $questionOptions = $questionRow['question_options'];
      $questionType = $questionRow['question_type_id'];
    }

    // Create an array to store the unique question_type_id values
    $questionTypes = array();

    // Fetch each row from the result set
    while ($row = $result->fetch_assoc()) {
      $questionType = $row['question_type_id'];

      // Store the question_type_id
      $questionTypes[] = $questionType;
    }

    // Sort the question types in ascending order
    sort($questionTypes);

    // Determine the sections based on the available question types
    $sections = array();

    // Categorize question types into sections A, B, and C
    if (in_array(0, $questionTypes) && in_array(1, $questionTypes) && in_array(2, $questionTypes)) {
      $sections = ['A', 'B', 'C'];
    } elseif (in_array(0, $questionTypes) && in_array(1, $questionTypes)) {
      $sections = ['A', 'B'];
    } elseif (in_array(0, $questionTypes) && in_array(2, $questionTypes)) {
      $sections = ['A', 'B'];
    } elseif (in_array(1, $questionTypes) && in_array(2, $questionTypes)) {
      $sections = ['A', 'B'];
    } else {
      $sections = ['A', 'B', 'C'];
    }
  }

?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $assessmentName; ?></title>
  </head>

  <body>
    <?php
    include "navbar.php";
    ?>

    <?php
    if (in_array('A', $sections)) {
    ?>
      <button type="button" class="collapsible">Section A</button>
      <div class="content">
        <?php
        // For all questions, if question_type == MCQ
        ?>
      </div>
    <?php
    }
    ?>

    <?php
    if (in_array('B', $sections)) {
    ?>
      <button type="button" class="collapsible">Section B</button>
      <div class="content">
        <?php
        // For all questions, if question_type == FIB
        ?>
      </div>
    <?php
    }
    ?>

    <?php
    if (in_array('C', $sections)) {
    ?>
      <button type="button" class="collapsible">Section C</button>
      <div class="content">
        <?php
        // For all questions, if question_type == <insert type>
        ?>
      </div>
  <?php
    }
  }
  ?>
  <button type="button" class="submit-assessment-button">Submit</button>

  <script src="script.js"></script>
  </body>

  </html>