<?php
// Check user session
include("checkSession.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Create Assessment</title>
</head>

<body>
    <?php
    include "navbar.php"
    ?>
    <h3>Create Assessment</h3>

    <form id="postForm" method="post" action="doCreateAssessment.php">
        <label for="idName">Assessment Name:</label>
        <input type="text" id="idName" name="name" required />
        <br><br>
        <label for="idInstuc">Instructions:</label>
        <br>
        <textarea id="idInstuc" name="instruction" rows="5" cols="30" required></textarea>
        <br><br>
        <label for="idTime">Enter in release Time:</label>
        <br>
        <input type="datetime-local" id="idTime" name="time" required />
        <p><label for="idQuestion">Questions:</label></p>
        <div class="form-group" id="inputFields">
                <input id='inputOptions' type="text" class="inputOptions" name="inputOptions[]" placeholder="Enter Question ID" required/>
            </div>
            <button type="button" id="addField">Add new questions</button>
            <br><br>
        <br><br>
        <input type="submit" value="Create" />
    </form>

    <script>
    // Add new input field
            $("#addField").click(function() {
                var questionType = $("#questionType").val();
                var inputFieldHtml = '<div><input type="text" name="inputOptions[]" placeholder="Enter Question ID" required><button type="button" class="removeField">Remove</button></div>';
                $("#inputFields").append(inputFieldHtml);
            });

            // Remove the selected input field
            $(document).on("click", ".removeField", function() {
                $(this).parent('div').remove();
            });
    </script>
</body>

</html>