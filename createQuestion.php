<?php
// Check user session
include("checkSession.php");
// php file that contains the common database connection code
include "dbFunctions.php";

$query = "SELECT * FROM question_type";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
while ($row = mysqli_fetch_assoc($result)) {
    $questionArr[] = $row;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve the answer options from the form
        $question_type_id = $_POST['questionType'];
        $question_text = $_POST['inputText'];
        $answer_options = $_POST['inputOptions'];

        // Convert the array to a JSON string
        $jsonAnswerOptions = json_encode($answer_options);

        // Prepare and execute the query
        $questionQuery = "INSERT INTO question_bank (question_type_id, question_text, answer_options, question_answer VALUES ('$question_type_id', '$question_text', '$jsonAnswerOptions')";
    }
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="stylesheets/style.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Create Question</title>
</head>

<body>
    <h1>Create Question</h1>
    <div>Choose the question type</div>
    <form id="questionForm" class="questionForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <select id='questionType' name='questionType'>
            <?php
            for ($i = 0; $i < count($questionArr); $i++) {
                $name = $questionArr[$i]['type_name'];
                $idType = $questionArr[$i]['type_id'];
                echo "<option value=$idType>$name</option>";
            }
            ?>
        </select>
        <div id="questionDetails" class="question-root-details">
            <br><br>
            <div class="form-group" id="inputFields">
                <label for="inputText" id='inputText'>Question Text:</label><br>
                <textarea class="inputText" name="inputText"></textarea><br><br>
                <label for="inputOptions" id='inputOptionsLabel'><?php echo $questionArr[0]['type_name']; ?> Options:</label><br>
                <input id='inputOptions' type="text" class="inputOptions" name="inputOptions[]" />
                <input type="radio" name="answer" value="0"><br>
                <input id='inputOptions' type="text" class="inputOptions" name="inputOptions[]" />
                <input type="radio" name="answer" value="1"><br>
            </div>
            <button type="button" id="addField">Add new option</button>
            <br><br>
            <label for="myFile">Files:</label>
            <input type="file" id="myFile" name="filename">
            <br><br>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>

    <script>
        function redirectToPage(url) {
            window.location.href = url;
        }
        $(document).ready(function() {
            // Update form content based on the selected dropdown option
            $("#questionType").change(function() {
                var selectedOption = $(this).val();
                var inputFieldLabel = "";
                var inputFieldType = "";

                if (selectedOption == 0) {
                    inputFieldLabel = "<?php echo $questionArr[0]['type_name']; ?>";
                    inputFieldType = "text";
                } else if (selectedOption == 1) {
                    inputFieldLabel = "<?php echo $questionArr[1]['type_name']; ?>";
                    inputFieldType = "text";
                } else if (selectedOption == 2) {
                    inputFieldLabel = "<?php echo $questionArr[2]['type_name']; ?>";
                    inputFieldType = "text";
                }

                // Reset input options
                var inputField = document.getElementById("inputOptions");
                inputField.innerHTML = '<input id="inputOptions" type="text" type="text" class="inputOptions" name="inputOptions[]"/><input type="radio" name="answer"><br>';

                // Set label name
                var inputFieldLabelText = document.getElementById("inputOptionsLabel");
                inputFieldLabelText.innerHTML = inputFieldLabel + ' Options:';
            });

            // Add new input field
            $("#addField").click(function() {
                var questionType = $("#questionType").val();
                var inputFieldHtml = '<div><input type="text" name="inputOptions[]" placeholder=""><input type="radio" name="answer"><button type="button" class="removeField">Remove</button></div>';
                $("#inputFields").append(inputFieldHtml);
            });

            // Remove the selected input field
            $(document).on("click", ".removeField", function() {
                $(this).parent('div').remove();
            });
        });
    </script>
</body>

</html>