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
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
                <button id="Create_Button">Create Questions</button>
            </div>
            <div id="Create_Modal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>
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
                        <textarea class="inputText" name="questionText" required></textarea>
                        <br>
                        <button type="button" onclick="addInputField()">Add Field</button>
                        <br>
                        <div id="inputFieldsContainer">
                            <!-- The dynamically created input fields will be appended here -->
                            <input type="file" name="image" accept="image/*">
                            <div id="fieldContainer0" class="field-container">
                                <input type="text" name="inputField[]" placeholder="Enter option" required>
                                <input type="radio" name="selectedField" value="0" required>
                            </div>
                            <div id="fieldContainer1" class="field-container">
                                <input type="text" name="inputField[]" placeholder="Enter option" required>
                                <input type="radio" name="selectedField" value="1" required>
                            </div>
                        </div>
                        <button type="submit" name="submit">Submit</button>
                    </form>
                </div>
            </div>
            <!-- Datatable -->
            <main class="tableMain">
                <table id='exerciseTable' class="display table-striped">
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
                            return '<a href="questionEdit.php?question_id=' + row.question_id + '">Edit</a>';
                        }
                    },
                    // Use exercise_id to indicated exercise to delete
                    {
                        title: 'Delete',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="questionDelete.php?question_id=' + row.question_id + '">Delete</a>';
                        }
                    }
                ]
            });
        });
        // Redirects the user to the specified URL
        function redirectToPage(url) {
            window.location.href = url;
        }

        // Get the modal
        var modal = document.getElementById("Create_Modal");

        // Get the button that opens the modal
        var btn = document.getElementById("Create_Button");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
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
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="0" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="1" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            } else if (selectedQuestionType === '<?php echo $questionArr[1]['type_id'] ?>') { // Fill in the blank
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="0" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="1" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';
            } else if (selectedQuestionType === '<?php echo $questionArr[2]['type_id'] ?>') {
                inputFieldsContainer.innerHTML += '<input type="file" name="image" accept="image/*">'; // Image upload

                inputFieldsContainer.innerHTML += '<div id="fieldContainer0" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="0" required>'; // Radio button
                inputFieldsContainer.innerHTML += '</div>';

                inputFieldsContainer.innerHTML += '<div id="fieldContainer1" class="field-container">'; // Input field container
                inputFieldsContainer.innerHTML += '<input type="text" name="inputField[]" placeholder="Enter option" required>'; // Input field
                inputFieldsContainer.innerHTML += '<input type="radio" name="selectedField" value="1" required>'; // Radio button
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
            inputField.required = true;

            // Create the radio button
            const radioButton = document.createElement("input");
            radioButton.type = "radio";
            radioButton.name = "selectedField";
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
    </script>
</body>

</html>