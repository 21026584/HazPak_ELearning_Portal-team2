<?php
// Check user session
include("checkSession.php");
// php file that contains the common database connection code
include "dbFunctions.php";

$query = "SELECT * FROM question_type";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
while ($row = mysqli_fetch_assoc($result)) {
   $questionArr[] = $row;
   //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Retrieve the answer options from the form
      //$question_type_id = $_POST['questionType'];
      //$question_text = $_POST['inputText'];
      //$answer_options = $_POST['inputOptions'];

      // Convert the array to a JSON string
      //$jsonAnswerOptions = json_encode($answer_options);

      // Prepare and execute the query
      //$questionQuery = "INSERT INTO question_bank (question_type_id, question_text, answer_options, question_answer VALUES ('$question_type_id', '$question_text', '$jsonAnswerOptions')";
   //}
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
   <title>Dynamically Change Input Fields</title>
</head>

<body>
   <form id="questionForm" class="questionForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="questionType">Question Type:</label>
      <select id="questionType" onchange="changeQuestionType()">
         <?php
            for ($i = 0; $i < count($questionArr); $i++) {
                $name = $questionArr[$i]['type_name'];
                $idType = $questionArr[$i]['type_id'];
                echo "<option value=$idType>$name</option>";
            }
            ?>
      </select>
      <br />
      <input type="text" name="mcqInputField[]" placeholder="Enter option">
      <input type="radio" name="selectedField" value="inputField1">
      <button type="button" onclick="addInputField()">Add Field</button>
      <div id="inputFieldsContainer">
         <!-- The dynamically created input fields will be appended here -->
      </div>
      <button type="submit">Submit</button>
   </form>

   <script>
      let currentQuestionType = '<?php $questionArr[0]['type_id'] ?>'; // Default question type

      function changeQuestionType() {
         const inputFieldsContainer = document.getElementById("inputFieldsContainer");

         // Clear the container
         inputFieldsContainer.innerHTML = "";

         // Get the selected question type
         const questionTypeSelect = document.getElementById("questionType");
         const selectedQuestionType = questionTypeSelect.value;

         if (selectedQuestionType === '<?php $questionArr[0]['type_id'] ?>') {
            // Create MCQ input fields
            const mcqInputField = document.createElement("input");
            mcqInputField.type = "text";
            mcqInputField.name = "inputField[]";
            mcqInputField.placeholder = "Enter option";
            inputFieldsContainer.appendChild(mcqInputField);

         } else if (selectedQuestionType === '<?php $questionArr[1]['type_id'] ?>') {
            // Create Fill in the Blanks input fields
            const fillBlanksInputField = document.createElement("input");
            fillBlanksInputField.type = "text";
            fillBlanksInputField.name = "inputField[]";
            fillBlanksInputField.placeholder = "Enter option";
            inputFieldsContainer.appendChild(fillBlanksInputField);
         }

         // Update the current question type
         currentQuestionType = selectedQuestionType;
      }

      document.getElementById("questionForm").addEventListener("submit", function(event) {
         event.preventDefault(); // Prevent form submission

         // Retrieve the selected question type
         console.log("Selected question type:", currentQuestionType);

         // You can perform further processing or make an AJAX request to send the selected question type to the server
      });

      let fieldCounter = 0; // Counter for unique field IDs

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
         inputField.id = "inputField" + fieldCounter;
         inputField.placeholder = "Enter option";

         // Create the radio button
         const radioButton = document.createElement("input");
         radioButton.type = "radio";
         radioButton.name = "selectedField";
         radioButton.value = "inputField" + fieldCounter;

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

      document.getElementById("questionForm").addEventListener("submit", function(event) {
         event.preventDefault(); // Prevent form submission

         // Retrieve the selected radio button value
         const selectedField = document.querySelector('input[name="selectedField"]:checked');
         if (selectedField) {
            console.log("Selected field value:", selectedField.value);
         } else {
            console.log("No field selected");
         }
      });
   </script>
</body>

</html>