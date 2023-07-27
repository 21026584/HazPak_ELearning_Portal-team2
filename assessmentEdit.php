<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

$assessmentID = $_GET['assessment_id'];

// create query to retrieve a single record based on the value of $compID 
$queryItem = "SELECT * FROM assessments
          WHERE assessment_id=$assessmentID";

// execute the query
$resultItem = mysqli_query($link, $queryItem) or 
                die(mysqli_error($link));

// fetch the execution result to an array
$rowItem = mysqli_fetch_array($resultItem);

//Getting the questions from json file
$questionArr =  json_decode($rowItem['questions'], true);

//getting the course id
$query = "SELECT * FROM courses";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
while ($row = mysqli_fetch_assoc($result)) {
    $course[] = $row;
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Edit Assessment</title>
    </head>
    <body>
    <h3>Edit Assessment</h3>

    <form id="postForm" method="post" action="doAssessmentEdit.php">
        <!-- Ensure that assessment ID is carried over -->
        <input type="hidden" name="idAssessment" value="<?php echo $rowItem['assessment_id'] ?>"/>
        <label for="idName">Assessment Name:</label>
        <input type="text" id="idName" name="name" value="<?php echo $rowItem['assessment_name']?>" required />
        <br><br>
        <label for="idCourse">Course:</label>
        <select id="idCourse" name="idCourse" required>
            <?php
            // list the course from database and shows current assessment course
            for ($i = 0; $i < count($course); $i++) {
                $selectCourse = $course[$i]['course_id'];
                if ($selectCourse == $rowItem['instructions']){
                    echo "<option selected>$selectCourse</option>";
                } else {
                    echo "<option>$selectCourse</option>";
                }
                
            }
            ?>
        </select>
        <br><br>
        <label for="idInstuc">Instructions:</label>
        <br>
        <textarea id="idInstuc" name="instruction" rows="5" cols="30" required><?php echo $rowItem['instructions']?></textarea>
        <br><br>
        <label for="idTime">Enter in release Time:</label>
        <br>
        <input type="datetime-local" id="idTime" name="time" value="<?php echo $rowItem['release_datetime']?>" required />
        <p><label for="inputQuestion">Questions:</label></p>
        <div class="form-group" id="inputQuestion">
            <input id='questionID' type="text" class="questionID" name="inputQuestion[]" placeholder="Enter Question ID" value="<?php echo $questionArr[0]?>" required/>
            <?php
                for ($i = 1; $i < count($questionArr); $i++) {
                    ?>
                    <div><input type="text" name="inputQuestion[]" placeholder="Enter Question ID" value="<?php echo $questionArr[$i]; ?>" required><button type="button" class="removeField">Remove</button></div>
                    <?php
                }
            ?>
        </div>
            <button type="button" id="addField">Add new questions</button>
            <br>
        <br><br>
        <input type="submit" value="Finish Edit" />
    </form>
    
    <script>
    // Add new input question field
        $("#addField").click(function() {
            var questionType = $("#questionType").val();
            var inputFieldHtml = '<div><input type="text" name="inputQuestion[]" placeholder="Enter Question ID" required><button type="button" class="removeField">Remove</button></div>';
            $("#inputQuestion").append(inputFieldHtml);
        });

        // Remove the selected input field
        $(document).on("click", ".removeField", function() {
            $(this).parent('div').remove();
        });
    </script>
    </body>
</html>