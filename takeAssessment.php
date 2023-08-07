<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");

// Retrieve the selected assessment ID from the URL
$assessmentId = $_GET['assessment_id'];

// Query to fetch assessment details based on the ID
$query = "SELECT A.assessment_name, A.release_datetime, A.questions, A.end_time
          FROM assessments AS A
          WHERE assessment_id = '$assessmentId'";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Initialise values
$data = array();

// Fetching user info from database
if ($row = mysqli_fetch_assoc($result)) {
    // Retrieve information from the selected assessment role
    $assessmentName = $row['assessment_name'];
    $releaseTime = $row['release_datetime'];
    $duration = $row['end_time'];

    // Get the questions column value (JSON string)
    $questionsJSON = $row['questions'];

    // Convert the JSON string to an array of question_ids
    $questionIds = json_decode($questionsJSON, true);

    // If there are no question_ids, display an error message or handle the case as required
    if (empty($questionIds)) {
        echo "No questions found for this assessment.";
        exit;
    }

    // Use the question_ids to retrieve data from the question_bank table
    $questionIdsString = implode(',', $questionIds);

    // Execute the query to fetch questions
    $questionQuery = "SELECT question_id, question_type_id, question_text, question_answer, answer_options, question_image
                    FROM question_bank
                    WHERE question_id IN ($questionIdsString)";
    $questionResult = mysqli_query($link, $questionQuery) or die(mysqli_error($link));

    // Define an array to store the questions for each section
    $sectionQuestions = array(
        'A' => array(), // For MCQ questions
        'B' => array(), // For FIB questions
    );

    // Loop through questions and categorize them into sections
    while ($questionRow = $questionResult->fetch_assoc()) {
        $questionType = $questionRow['question_type_id'];

        // Decode the answer_options JSON string into an array
        $answerOptions = json_decode($questionRow['answer_options'], true);

        // Now you have access to the answer_options for each question in $answerOptions
        // You can use this array to display answer choices or perform other actions as needed.

        // Categorize questions based on their types into respective sections
        if ($questionType == 0) { // Assuming question_type_id for MCQ is 0
            $sectionQuestions['A'][] = $questionRow; // Add to Section A
        } elseif ($questionType == 1) { // Assuming question_type_id for FIB is 1
            $sectionQuestions['B'][] = $questionRow; // Add to Section B
        }
    }

    // Define the sections array based on the keys present in the $sectionQuestions array
    $sections = array_keys($sectionQuestions);
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
    <form id="assessmentForm" method="post" action="submit_assessment.php">
        <input type="hidden" name="assessment_id" value="<?php echo $assessmentId; ?>">
        <div class="left_panel">
            <?php
                    $questionCounter = 1; // Initialize the question counter

                    if (in_array('A', $sections)) : ?>
                        <button type="button" class="collapsible">Section A</button>
                        <div class="collapsible-content question-column">
                            <?php foreach ($sectionQuestions['A'] as $questionRow) : ?>
                                <div class="question-content">
                                    <?php if (!empty($questionRow['question_image'])) : ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($questionRow['question_image']); ?>" alt="Question Image" class="question_image">
                                    <?php endif; ?>
                                    <p class="question_text"><?php echo $questionCounter . ". " . $questionRow['question_text']; ?></p>
                                    <?php
                                    // Add your logic to display the answer choices for MCQ questions

                                    // Decode the answer_options JSON string into an array
                                    $answerOptions = json_decode($questionRow['answer_options'], true);

                                    if (!empty($answerOptions)) {
                                        foreach ($answerOptions as $index => $option) {
                                            // Generate unique IDs for the radio buttons
                                            $radioId = "radio_" . $questionRow['question_id'] . "_" . $index;
                                            ?>
                                            <label for="<?php echo $radioId; ?>">
                                            <input type="hidden" name="question_ids[]" value="<?php echo $questionRow['question_id']; ?>">
                                            <input type="radio" id="<?php echo $radioId; ?>" name="question_<?php echo $questionRow['question_id']; ?>" value="<?php echo $index; ?>">
                                                <?php echo $option; ?>
                                            </label>
                                            <?php
                                        }
                                    }
                                    //Example: $answerOptions = $answerOptions[$questionRow['question_id']];
                                    ?>
                                

                                </div>
                            <?php 
                            $questionCounter++; // Increment the question counter
                            endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array('B', $sections)) : ?>
                        <button type="button" class="collapsible">Section B</button>
                        <div class="collapsible-content question-column">
                            <?php foreach ($sectionQuestions['B'] as $questionRow) : ?>
                                <div class="question-content">
                                    <?php if (!empty($questionRow['question_image'])) : ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($questionRow['question_image']); ?>" alt="Question Image" class="question_image">
                                    <?php endif; ?>
                                    <p class="question_text"><?php echo $questionCounter . ". " . $questionRow['question_text']; ?></p>
                                    <input type="hidden" name="question_ids[]" value="<?php echo $questionRow['question_id']; ?>">
                                    <input type="text" name="question_<?php echo $questionRow['question_id']; ?>" class="fib-input" placeholder="Your answer here">
                                </div>
                                <?php 
                            $questionCounter++; // Increment the question counter
                            endforeach; ?>
                        </div>
                    <?php endif; ?>

        </div>
        <div class="right_panel">
            <div id="countdown-timer"></div>
            <input type="hidden" name="time_taken" value="">
            <button type="submit" class="submit-assessment-button">Submit</button>
        </div>

        
    </form>

    <script>
        // Get the duration string from the PHP variable
        var starttime = "<?php echo $releaseTime; ?>";
        var durationString = "<?php echo $duration; ?>";

        // Parse hours, minutes, and seconds from the duration string
        var durationParts = durationString.split(":");
        var hours = parseInt(durationParts[0]);
        var minutes = parseInt(durationParts[1]);
        var seconds = parseInt(durationParts[2]);

        // Convert hours, minutes, and seconds to seconds
        var durationInSeconds = hours * 3600 + minutes * 60 + seconds;

        // Calculate the end time by adding the duration to the current time
        var now = new Date(starttime);
        var endTime = new Date(now.getTime() + durationInSeconds * 1000); // Convert duration to milliseconds

        // Update the countdown and hidden input value every second
        var countdownInterval = setInterval(function() {
            var now = new Date().getTime();
            var timeRemaining = endTime - now;

            if (timeRemaining <= 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown-timer").innerHTML = "Time's up!";
                document.querySelector("input[name='time_taken']").value = durationInSeconds;
            } else {
                var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                document.getElementById("countdown-timer").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
                document.querySelector("input[name='time_taken']").value = durationInSeconds - Math.floor(timeRemaining / 1000);
            }
        }, 1000);

        // Function to submit the form when time is up
        function submitFormWhenTimeIsUp() {
            clearInterval(countdownInterval);
            document.getElementById("countdown-timer").innerHTML = "Time's up!";
            document.querySelector("input[name='time_taken']").value = durationInSeconds;
            document.getElementById("assessmentForm").submit();
        }

        // Set a timeout to call the function when time is up
        setTimeout(submitFormWhenTimeIsUp, durationInSeconds * 1000); // Convert duration to milliseconds
    </script>


    
    <script src="script.js"></script>
</body>

</html>
