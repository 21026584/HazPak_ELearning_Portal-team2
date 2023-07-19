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
    echo "POST successfully!";
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        echo "IMAGE if statement successfully!";
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
    if ($questionResult) {
        echo "Question inserted successfully!";
    } else {
        echo "Error inserting question: " . mysqli_error($link);
    }
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
    <?php
    for ($i = 0; $i < count($questionArr); $i++) {
        echo $questionArr[$i]['type_id'];
    }
    ?>
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
            <input type="file" name="imageFiles" accept="image/*">
            <div class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option">
                <input type="radio" name="selectedField" value="inputField0">
            </div>
            <div class="field-container">
                <input type="text" name="inputField[]" placeholder="Enter option">
                <input type="radio" name="selectedField" value="inputField1">
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
                inputFieldsContainer.innerHTML += '<input type="file" name="imageFiles" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            } else if (selectedQuestionType === '<?php echo $questionArr[1]['type_id'] ?>') { // Fill in the blank
                inputFieldsContainer.innerHTML += '<input type="file" name="imageFiles" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            } else if (selectedQuestionType === '<?php echo $questionArr[2]['type_id'] ?>') {
                inputFieldsContainer.innerHTML += '<input type="file" name="imageFiles" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField">'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            }

            // Update the current question type
            currentQuestionType = selectedQuestionType;
        }

        function addInputField() {
            const inputFieldsContainer = document.getElementById("inputFieldsContainer");

            // Create a new input field container
            const fieldContainer = document.createElement("div");
            fieldContainer.id = "fieldContainer" + fieldCounter;
            fieldContainer.classList.add("field-container");

            // Create the input field
            const inputField = document.createElement("input");
            inputField.type = "text";
            inputField.name = "inputField";
            inputField.placeholder = "Enter option";

            // Create the radio button
            const radioButton = document.createElement("input");
            radioButton.type = "radio";
            radioButton.name = "selectedField";

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
        }

        // Function to dynamically update radio button values based on input field values
        function updateRadioValues() {
            const fieldContainers = document.getElementsByClassName("field-container");
            const radioButtons = document.querySelectorAll('input[name="selectedField"]');

            for (let i = 0; i < fieldContainers.length; i++) {
                const inputField = fieldContainers[i].querySelector('input[name="inputField[]"]');
                radioButtons[i].value = inputField.value;
            }
        }

        // Call the updateRadioValues function whenever an input field value changes
        const inputFields = document.querySelectorAll('input[name="inputField[]"]');
        inputFields.forEach(inputField => {
            inputField.addEventListener("input", updateRadioValues);
        });
    </script>
</body>

</html>