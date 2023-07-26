<?php
// Check user session
include("checkSession.php");
// php file that contains the common database connection code
include "dbFunctions.php";

$query = "SELECT * FROM question_type";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
while ($row = mysqli_fetch_assoc($result)) {
    $questionArr[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        // Retrieve the image file data
        $image = $_FILES["image"]["tmp_name"];

        // Read the image file content
        $question_image = addslashes(file_get_contents($image));
    } else {
        $question_image = null;
    }
    // Retrieve form data
    $question_type_id = $_POST['questionType'];
    $question_text = $_POST['questionText'];
    $question_answer = $_POST['selectedField'];
    $answer_options = $_POST['inputField'];

    // Convert the answer_options array to a JSON string
    $answer_options_JSON = json_encode($answer_options);

    $questionQuery = "INSERT INTO question_bank (question_type_id, question_text, question_answer, answer_options, question_image) VALUES ('$question_type_id', '$question_text', '$question_answer', '$answer_options_JSON', '$question_image')";
    $questionResult = mysqli_query($link, $questionQuery) or die(mysqli_error($link));
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Create Question</title>
</head>

<body>
    <form id="questionForm" enctype="multipart/form-data" class="questionForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="questionType">Question Type:</label>
        <select id="questionType" name="questionType" onchange="changeQuestionType()">
            <?php
            for ($i = 0; $i < count($questionArr); $i++) {
                $name = $questionArr[$i]['type_name'];
                $idType = $questionArr[$i]['type_id'];
                echo "<option value=$idType>$name</option>";
            }
            ?>
        </select>
        <br>
        <textarea class="inputText" name="questionText"></textarea>
        <br>
        <button type="button" onclick="addInputField()">Add Field</button>
        <br>
        <div id="inputFieldsContainer">
            <!-- The dynamically created input fields will be appended here -->
            <input type="file" name="image" accept="image/*">
            <div id="fieldContainer0" class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option">
                <input type="radio" name="selectedField" value="0">
            </div>
            <div id="fieldContainer1" class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option">
                <input type="radio" name="selectedField" value="1">
            </div>
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>

    <script>
        function redirectToPage(url) {
            window.location.href = url;
        }

        let currentQuestionType = '<?php echo $questionArr[0]['type_id'] ?>'; // Default question type

        function changeQuestionType() {
            const inputFieldsContainer = document.getElementById("inputFieldsContainer");

            // Clear the container
            inputFieldsContainer.innerHTML = '';

            // Get the selected question type
            const questionTypeSelect = document.getElementById("questionType");
            const selectedQuestionType = questionTypeSelect.value;

            if (selectedQuestionType == '<?php echo $questionArr[0]['type_id'] ?>') { // Multiple Choice
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="0">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="1">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            } else if (selectedQuestionType === '<?php echo $questionArr[1]['type_id'] ?>') { // Fill in the blank
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="0">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="1">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            } else if (selectedQuestionType === '<?php echo $questionArr[2]['type_id'] ?>') {
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="0">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="1">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            }

            // Update the current question type
            currentQuestionType = selectedQuestionType;
        }
        // Counter for answer index
        fieldCounter = 2;

        function addInputField() {
            const inputFieldsContainer = document.getElementById("inputFieldsContainer");

            // Create a new input field container
            const fieldContainer = document.createElement("div");
            fieldContainer.id = "fieldContainer" + fieldCounter;
            fieldContainer.classList.add("field-container");

            // Create the input field
            const inputField = document.createElement("input");
            inputField.type = "text";
            inputField.name = "inputField[]";
            inputField.placeholder = "Enter option";

            // Create the radio button
            const radioButton = document.createElement("input");
            radioButton.type = "radio";
            radioButton.name = "selectedField";
            radioButton.value = fieldCounter;

            // Create the remove button
            const removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.textContent = "Remove";
            removeButton.onclick = function() {
                removeInputField(fieldContainer.id);
            };

            // Append the input field, radio button, and remove button to the field container
            fieldContainer.appendChild(inputField);
            fieldContainer.appendChild(radioButton);
            fieldContainer.appendChild(removeButton);

            // Append the field container to the input fields container
            inputFieldsContainer.appendChild(fieldContainer);

            fieldCounter++;
        }

        function removeInputField(fieldContainerId) {
            const fieldContainer = document.getElementById(fieldContainerId);
            fieldContainer.remove();
            fieldCounter--;
        }

    </script>
</body>

</html>