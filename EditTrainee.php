<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

$user_id = $_GET['user_id'];
// $traineeID = $_POST['user_id'];

//echo $itemID;

// create query to retrieve a single record based on the value of $compID 
$queryItem = "SELECT * FROM users
WHERE user_id='$user_id'";

// execute the query
 $resultItem = mysqli_query($link, $queryItem) or 
                die(mysqli_error($link)); 

// fetch the execution result to an array
$rowItem = mysqli_fetch_array($resultItem);





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

    <h3>Edit Trainee</h3>

    <form id="EditTraineeForm" method="post" action="doTraineeEdit.php">
        <label for="UpdatedUsername">Username:</label>
        <input type="text" id="UpdatedUsername" name="UpdatedUsername" value="<?php echo $rowItem['username']?>" required  />
        <br>
        <label for="UpdatedTraineeID">Trainee ID:</label>
        <input type="text" id="UpdatedTraineeID" name="UpdatedTraineeID" value="<?php echo $rowItem['user_id']?>" required />
        <br>
        <label for="UpdatedTraineePassword">Password:</label>
        <input type="text" id="UpdatedTraineePassword" name="UpdatedTraineePassword" value="<?php echo $rowItem['password']?>" required />
      <br>
        <label for="intake">Intake:</label>
        <input type="text" id="intake" name="intake" value="<?php echo $rowItem['intake']?>"required />
        <br>
        <input type="submit" value="Edit" />
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