<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");

// Retrieve the data from the AJAX request
$modal_type = $_POST['modal_type'];
$question_id = $_POST['question_id'];

// Fetching question_type info from database
$query = "SELECT * FROM question_type";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
while ($row = mysqli_fetch_assoc($result)) {
    $questionArr[] = $row;
}

// Fetching question_bank info from database for edit
$questionQuery = "SELECT * FROM question_bank
                  WHERE question_id = '$question_id'";
$questionResult = mysqli_query($link, $questionQuery) or die(mysqli_error($link));
if ($row = mysqli_fetch_assoc($questionResult)) {
    $type_id = $row['question_type_id'];
    $question_text = $row['question_text'];
    $question_answer_JSON = $row['question_answer'];
    $answer_options_JSON = $row['answer_options'];
    $question_answer = json_decode($question_answer_JSON);
    $answer_options = json_decode($answer_options_JSON);
    $question_image = $row['question_image'];
    $image = base64_encode($question_image);
}

if ($modal_type == 0) { // Create Question
    echo '
    CREATE QUESTION
        <span class="close">&times;</span>
        <form id="questionForm" enctype="multipart/form-data" class="questionForm" method="POST" action="/HazPak_ELearning_Portal-team2/questionBank.php">
        <label for="questionType">Question Type:</label>
        <select id="questionType" name="questionType" onchange="changeQuestionType()">
    ';
    for ($i = 0; $i < count($questionArr); $i++) {
        $name = $questionArr[$i]['type_name'];
        $idType = $questionArr[$i]['type_id'];
        echo "<option value=$idType>$name</option>";
    }
    echo '
        </select>
        <br>
        <br>
        <textarea class="inputText" name="questionText" cols="90" required></textarea>
        <br>
        <div id="inputFieldsContainer">
            <!-- The dynamically created input fields will be appended here -->
            <button type="button" onclick="addInputField()">Add Field</button>
            <br>
            <input type="file" name="image" accept="image/*">
            <br>
            <div id="fieldContainer0" class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option" required>
                <input type="radio" name="answerField[]" value="0" required>
            </div>
            <div id="fieldContainer1" class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option" required>
                <input type="radio" name="answerField[]" value="1" required>
            </div>
        </div>
        <br>
        <button type="submit" class="questionFormButton" name="createForm">Submit</button>
    </form>
    ';
} else if ($modal_type == 1) { // Edit Question
    echo '
        EDIT QUESTION
        <span class="close">&times;</span>
        <form id="editForm" enctype="multipart/form-data" class="questionForm" method="POST" action="/HazPak_ELearning_Portal-team2/questionBank.php">
            <label for="questionType">Question Type:</label>
            <select id="questionType" name="questionType" onchange="changeQuestionType()">
    ';
    for ($i = 0; $i < count($questionArr); $i++) {
        $name = $questionArr[$i]['type_name'];
        $idType = $questionArr[$i]['type_id'];
        if ($questionArr[$i]['type_id'] == $type_id) {
            echo "<option value=$idType selected>$name</option>";
        } else {
            echo "<option value=$idType>$name</option>";
        }
    }
    echo '
            </select>
            <br>
            <br>
            <textarea class="inputText" name="questionText" cols="90" required>' . $question_text . '</textarea>
            <br>
        ';
    if ($type_id == 0) { // If edit MCQ
        echo '
        MCQ
                <div id="inputFieldsContainer">
                    <!-- The dynamically created input fields will be appended here -->
                    <button type="button" onclick="addInputField()">Add Field</button>
                    <br>
                    <input type="file" name="image" accept="image/*">
                    <br>
                    <div id="fieldContainer0" class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option" value="' . $answer_options[0] . '" required>
                <input type="radio" name="answerField[]" value="0" required ';
        if ($question_answer[0] == 0) {
            echo 'checked';
        }
        echo '>
            </div>
            <div id="fieldContainer1" class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option" value="' . $answer_options[1] . '" required>
                <input type="radio" name="answerField[]" value="1" required ';
        if ($question_answer[0] == 1) {
            echo 'checked';
        }
        echo '>';
        if (count($answer_options) > 2) {
            for ($i = 2; $i < count($answer_options); $i++) {
                echo '
                </div>
                <div id="fieldContainer' . $i . '" class="field-container">
                    <input type="text" name="inputField[]" placeholder="Enter option" value="' . $answer_options[$i] . '" required>
                    <input type="radio" name="answerField[]" value="' . $i . '" required ';
                if ($question_answer[0] == $i) {
                    echo 'checked';
                }
                echo '>
                </div>';
            }
        }
        echo '
                <br>
                <input type="hidden" name="questionId" value="' . $question_id . '">
                <button type="submit" class="questionFormButton" name="editForm">Submit</button>
            </form>
        ';
    } else if ($type_id == 1) { // If edit FIB
        echo '
    FIB
    <div id="inputFieldsContainer">
        <!-- The dynamically created input fields will be appended here -->
        <button type="button" onclick="addAnswerField()">Add Answer</button><br>
        <input type="file" name="image" accept="image/*">
        <div id="fieldContainer0" class="field-container">
        <input type="text" name="answerField[]" placeholder="Enter answer" value="' . $question_answer[0] . '" required>
        </div>
        ';
        if (count($question_answer) > 1) {
            for ($i = 1; $i < count($question_answer); $i++) {
                echo '
                <div id="fieldContainer' . $i . '" class="field-container">
                <input type="text" name="answerField[]" placeholder="Enter answer" value="' . $question_answer[$i] . '" required>
                </div>
                ';
            }
        }
        echo '
    </div>
    <br>
    <input type="hidden" name="questionId" value="' . $question_id . '">
    <button type="submit" class="questionFormButton" name="editForm">Submit</button>
</form>
';
    }
} else if ($modal_type == 2) { // Confirm Delete Question
    echo '
        <span class="close">&times;</span>
        <form id="deleteForm" enctype="multipart/form-data" class="questionForm" method="POST" action="/HazPak_ELearning_Portal-team2/questionBank.php";
        <div class="deleteWarning">Are you sure you want to delete this question?</div>
            <br>
            <input type="hidden" name="questionId" value="' . $question_id . '">
            <button type="submit" class="questionFormButton" name="deleteForm">Delete</button>
        </form>
    ';
} else {
}
