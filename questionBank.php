<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");

// Query for question bank
$query = "SELECT QB.question_id, QB.question_text, QT.type_name
    FROM question_bank AS QB
    INNER JOIN question_type AS QT
    ON QB.question_type_id = QT.type_id";
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

// Convert the data to JSON format
$jsonData = json_encode($data);

// Fetching question_type info from database
$query = "SELECT * FROM question_type";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
while ($row = mysqli_fetch_assoc($result)) {
    $questionArr[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["createForm"])) { // Create Question Handler

        // Retrieve form data
        $question_type_id = $_POST['questionType'];
        $question_text = $_POST['questionText'];
        $question_answers = $_POST['answerField'];
        $answer_options = $_POST['inputField'];


        // Convert the answer_options array to a JSON string
        if (isset($_POST['inputField']) && !empty($_POST['inputField'])) {
            $answer_options_JSON = json_encode($answer_options);
        } else {
            $answer_options_JSON = json_encode(null);
        }

        // Convert the answer_options array to a JSON string
        $question_answers_JSON = json_encode($question_answers);

        // Initialize variables for image handling
        $question_image = null;

        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            // Retrieve the image file data
            $image = $_FILES["image"]["tmp_name"];

            // Read the image file content
            $question_image = addslashes(file_get_contents($image));
        } else {
            $question_image = null;
        }

        // Create a prepared statement for the INSERT query
        $questionQuery = "INSERT INTO question_bank (question_type_id, question_text, question_answer, answer_options, question_image) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $questionQuery);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "issss", $question_type_id, $question_text, $question_answers_JSON, $answer_options_JSON, $question_image);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Successfully inserted
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Insertion failed
            echo "Insertion operation failed.";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else if (isset($_POST["editForm"])) { // Edit Question Handler
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            // Retrieve the image file data
            $image = $_FILES["image"]["tmp_name"];

            // Read the image file content
            $question_image = addslashes(file_get_contents($image));
        } else {
            $question_image = null;
        }

        // Retrieve form data
        $question_id = $_POST['questionId'];
        $question_type_id = $_POST['questionType'];
        $question_text = $_POST['questionText'];
        $question_answers = $_POST['answerField'];
        $answer_options = $_POST['inputField'];


        if (isset($_POST['inputField']) && !empty($_POST['inputField'])) {
            $answer_options_JSON = json_encode($answer_options);
        } else {
            $answer_options_JSON = json_encode(null);
        }

        // Convert the answer_options array to a JSON string
        $question_answers_JSON = json_encode($question_answers);
        
        // Create a prepared statement for the UPDATE query
        $questionQuery = "UPDATE question_bank
                          SET question_type_id = ?,
                            question_text = ?,
                            question_answer = ?,
                            answer_options = ?,
                            question_image = ?
                          WHERE question_id = ?";
        $stmt = mysqli_prepare($link, $questionQuery);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "issssi", $question_type_id, $question_text, $question_answers_JSON, $answer_options_JSON, $question_image, $question_id);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Check if the update was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Successfully updated
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Update failed
            echo "Update operation failed.";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else if (isset($_POST["deleteForm"])) { // Delete Question Handler
        $question_id = $_POST['questionId'];
        $questionQuery = "DELETE FROM question_bank
                          WHERE question_id = '$question_id'";
        $questionResult = mysqli_query($link, $questionQuery) or die(mysqli_error($link));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}


// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <title>Question Bank</title>
</head>


<body>
    <?php
    // Navbar
    include "navbar.php";

    // Show the Question Bank Page 
    if (($userRoleID == 0) || ($userRoleID == 1)) {
    ?>
        <div class="tableRoot">
            <header class='tableHeader'>
                <h1>Question Bank</h1>
            </header>
            <div class="assessmentButtonContainer">
                <button id="Create_Button" onclick="openModal(-1,0)">Create Questions</button>
            </div>
            <div id="modal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                </div>
            </div>
            <!-- Datatable -->
            <main class="tableMain">
                <table id='exerciseTable' class="display table-striped data-table">
                    <thead class="table-header">
                        <tr>
                            <!-- Headers -->
                            <td>Question ID</td>
                            <td>Question Text</td>
                            <td>Question Type</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </main>
        </div>
    <?php
        // If not admin/head admin role, 
    } else {
        header("Location: login.php");
        exit;
    }
    ?>
    <!-- Datatable.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialise DataTable
        $(document).ready(function() {
            // Compile database rows into json
            var jsonData = <?php echo $jsonData; ?>;
            $('#exerciseTable').DataTable({
                data: jsonData,
                columns: [{
                        title: 'Question ID',
                        data: 'question_id'
                    },
                    {
                        title: 'Question Text',
                        data: 'question_text'
                    },
                    {
                        title: 'Question Type',
                        data: 'type_name'
                    },
                    // Use exercise_id to indicated exercise to edit
                    {
                        title: 'Edit',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="#" onclick="openModal(' + row.question_id + ',1' + ')">Edit</a>';
                        }
                    },
                    // Use exercise_id to indicated exercise to delete
                    {
                        title: 'Delete',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="#" onclick="openModal(' + row.question_id + ',2' + ')">Delete</a>';
                        }
                    }
                ]
            });
        });
        // Redirects the user to the specified URL
        function redirectToPage(url) {
            window.location.href = url;
        }

        var modal = $("#modal");

        // When the "Edit" link is clicked, open the modal
        function openModal(question_id, modal_type) {
            // Send an AJAX request to a PHP script that retrieves modal details
            $.ajax({
                url: 'questionModal.php',
                type: 'POST',
                data: {
                    modal_type: modal_type,
                    question_id: question_id,
                },
                success: function(response) {
                    // Update the content of the modalContent with the response
                    $('.modal-content').html(response);
                    modal.show(); // Show the modal
                },

                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Close the modal when the user clicks on <span> (x)
        $(document).on("click", ".close", function() {
            modal.hide();
        });

        let currentQuestionType = '<?php echo $questionArr[0]['type_id'] ?>'; // Default question type 
        // Counter for answer index
        fieldCounter = 2;

        function changeQuestionType() {
            const inputFieldsContainer = document.getElementById("inputFieldsContainer");

            // Clear the container
            inputFieldsContainer.innerHTML = '';

            // Get the selected question type
            const questionTypeSelect = document.getElementById("questionType");
            const selectedQuestionType = questionTypeSelect.value;

            if (selectedQuestionType == '<?php echo $questionArr[0]['type_id'] ?>') { // Multiple Choice
                inputFieldsContainer.innerHTML += '<button type="button" onclick="addInputField()">Add Field</button><br>'; // Add input fields
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="answerField[]" value="0" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="answerField[]" value="1" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                fieldCounter = 2; // Set fieldCounter
            } else if (selectedQuestionType === '<?php echo $questionArr[1]['type_id'] ?>') { // Fill in the blank
                inputFieldsContainer.innerHTML += '<button type="button" onclick="addAnswerField()">Add Answer</button><br>'; // Add input fields
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="answerField[]" placeholder="Enter answer" required>'; // Answer field
                inputFieldsContainer.innerHTML += '</div>';

                fieldCounter = 1; // Set fieldCounter
            }

            // Update the current question type
            currentQuestionType = selectedQuestionType;
        }

        // Add answer for Multiple Choice question
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
            inputField.required = true;

            // Create the radio button
            const radioButton = document.createElement("input");
            radioButton.type = "radio";
            radioButton.name = "answerField[]";
            radioButton.value = fieldCounter;
            radioButton.required = true;

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

        // Add answer for Fill in the Blanks question
        function addAnswerField() {
            const answerFieldsContainer = document.getElementById("inputFieldsContainer");

            // Create a new answer field container
            const fieldContainer = document.createElement("div");
            fieldContainer.id = "fieldContainer" + fieldCounter;
            fieldContainer.classList.add("field-container");

            // Create the answer field
            const answerField = document.createElement("input");
            answerField.type = "text";
            answerField.name = "answerField[]";
            answerField.placeholder = "Enter answer";
            answerField.required = true;

            // Create the remove button
            const removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.textContent = "Remove";
            removeButton.onclick = function() {
                removeAnswerField(fieldContainer.id);
            };

            // Append the answer field and remove button to the answer container
            fieldContainer.appendChild(answerField);
            fieldContainer.appendChild(removeButton);

            // Append the field container to the answer fields container
            answerFieldsContainer.appendChild(fieldContainer);

            fieldCounter++;
        }

        function removeAnswerField(answerFieldContainerId) {
            const answerFieldContainer = document.getElementById(answerFieldContainerId);
            answerFieldContainer.remove();
            fieldCounter--;
        }
    </script>
</body>

</html>