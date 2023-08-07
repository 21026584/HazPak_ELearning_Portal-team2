<?php
// Include database connection
include("dbFunctions.php");

// Query
$query = "SELECT A.assessment_name, A.release_datetime, E.exercise_name, E.release_datetime
    FROM courses AS C
    INNER JOIN assessments AS A
    INNER JOIN exercises AS E
    ON C.course_id = A.course_id AND C.course_id = E.course_id";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Initialise values
$data = array();

// Fetching user info from database
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add each row to the data array
        $data[] = $row;
  
    }
}

// Close the database connection
mysqli_close($link);

// Convert the data to JSON format
$jsonData = json_encode($data);
?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="dashboard-style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Font Link for Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
  <script src="script.js" defer></script>
  <title>Dashboard</title>
</head>

<body>
  <?php
  // Check user session
  include("checkSession.php");
  // Navbar
  include "navbar.php";
  ?>
    
  
  
  <div class="left_panel">
    <h1 class="header">
      Dashboard
    </h1>
    <div class="row-container">
      <button type="button" class="collapsible">Available Assessments</button>
      <div class="collapsible-content">
      <?php
      // Include necessary files and database connection
      include("dbFunctions.php");

      // Get the current date and time
      date_default_timezone_set('Asia/Singapore');
      $currentDateTime = date("Y-m-d H:i:s");
      
      // Query to retrieve assessments with release_datetime in the past
      $query = "SELECT * FROM assessments WHERE release_datetime <= '$currentDateTime'";
      $result = mysqli_query($link, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        $assessmentId = $row['assessment_id'];
        $assessmentName = $row['assessment_name'];

        // Display the assessment information
        echo '<a class="assessment-anchor" href="assessments.php">' . 
             '<img id="assessment-img" src="https://images.unsplash.com/photo-1515266591878-f93e32bc5937?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGJsdWV8ZW58MHx8MHx8&auto=format&fit=crop&w=800&q=70">' .
             '<p>' . $assessmentName . '</p>' .
             '</a>';
      }

      
    ?>
      </div>
    </div>

    <div class="row-container">
      <button type="button" class="collapsible">Available Exercises</button>
      <div class="collapsible-content ">
        <?php
          // Query to retrieve exercises with release_datetime in the past
          $query = "SELECT * FROM exercises WHERE release_datetime <= '$currentDateTime'";
          $result = mysqli_query($link, $query);

          while ($row = mysqli_fetch_assoc($result)) {
            $exerciseId = $row['exercise_id'];
            $exerciseName = $row['exercise_name'];

            // Display the assessment information
            echo '<a class="assessment-anchor" href="assessments.php">' . 
                '<img id="assessment-img" src="https://images.unsplash.com/photo-1515266591878-f93e32bc5937?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGJsdWV8ZW58MHx8MHx8&auto=format&fit=crop&w=800&q=70">' .
                '<p>' . $exerciseName . '</p>' .
                '</a>';
          }
        ?>
      </div>
    </div>
  </div>
  <div class="right_panel">
    <div class="wrapper">
      <header>
        <p class="current-date"></p>
        <div class="icons">
          <span id="prev" class="material-symbols-rounded">chevron_left</span>
          <span id="next" class="material-symbols-rounded">chevron_right</span>
        </div>
      </header>
      <div class="calendar">
        <ul class="weeks">
          <li>Sun</li>
          <li>Mon</li>
          <li>Tue</li>
          <li>Wed</li>
          <li>Thu</li>
          <li>Fri</li>
          <li>Sat</li>
        </ul>
        <ul class="days"></ul>
      </div>
      <div class="assignments">
        <?php
          $currentDate = date('Y-m-d'); // Current date in 'Y-m-d' format
          $releasedExercises = array(); // To store released exercises
          $releasedAssessments = array(); // To store released assessments

          foreach ($data as $row) {
              if ($row['release_datetime'] === $currentDate) {
                  if (!empty($row['exercise_name'])) {
                      $releasedExercises[] = $row['exercise_name'];
                  }
                  if (!empty($row['assessment_name'])) {
                      $releasedAssessments[] = $row['assessment_name'];
                  }
              }
          }

          if (!empty($releasedExercises)) {
              echo '<h3>Released Exercises:</h3>';
              foreach ($releasedExercises as $exercise) {
                  echo '<div class="assignment">';
                  echo '<h4>' . $exercise . '</h4>';
                  // Add more exercise details as needed
                  echo '</div>';
              }
          }

          if (!empty($releasedAssessments)) {
              echo '<h3>Released Assessments:</h3>';
              foreach ($releasedAssessments as $assessment) {
                  echo '<div class="assignment">';
                  echo '<h4>' . $assessment . '</h4>';
                  // Add more assessment details as needed
                  echo '</div>';
              }
          }

          if (empty($releasedExercises) && empty($releasedAssessments)) {
              echo 'No exercises or assessments released today.';
          }
        ?>
      </div>
    </div>
  </div>
</div> 

<script src="script.js"></script>
<!-- Add the link for Tippy.js here -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
  const lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(); // getting last date of month
  let current_day = new Date();
  let assessmentN = " ";

    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
      current_day = new Date(currYear, currMonth,i);
      if(current_day == `<?php $assessmentRelease ?>${[i]}`){
        assessmentN = "<?php $assessmentName ?>";
      }
        
      
      tippy(`#my_day${i}`, {
          placement: 'right', //place tippy to the right
          interactive: true, //allow interaction in tippy (e.g. click and select text)
          content: `${current_day}`,
          allowHTML: true, //allow HTML in tippy content
          delay: 200, //delay tippy showing and hiding (in milliseconds)
          followCursor: true //get tippy to follow mouse cursor
      });
      console.log(current_day);
      

  }

  
  

      
  </script>
</body>

</html>