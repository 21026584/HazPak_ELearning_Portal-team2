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

//getting data for questions datatable
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
        <br><br>
        <p><label for="inputQuestion">Questions:</label></p>
        <!-- <div class="form-group" id="inputQuestion">
            <input id='displayQuestion' type="text" class="questionID" name="inputQuestion[]" placeholder="Enter Question ID" required/>
        </div>
        <button type="button" id="addField">Add new questions</button>
        <br><br> -->
        <p><a id='displayQuestion' type="text" class="questionID">Select Questions</a></p>
        <br>
        <div id="Create_Modal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <main class="tableMain">
                    <!-- Will have to rename table id to question table to avoid misunderstanding -->
                    <table id='exerciseTable' class="display table-striped question-table">
                        <thead class="table-header">
                            <tr>
                                <!-- Headers -->
                                <td>Question ID</td>
                                <td>Question Text</td>
                                <td>Question Type</td>
                                <td>Select</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </main>
                <p>Should be displaying checkbox with matching question ID<?php
                    for ($i = 0; $i < count($questionArr); $i++) {
                        $selectCourse = $questionArr[$i];
                        print_r($selectCourse);
                        print(", ");
                    }
                ?>
                </p>
            </div>
        </div>
        <input type="submit" value="Finish Edit" />
    </form>
    
 
    <!-- To display the database -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
                    // Has the value placed into inputQuestion[] so that it can be post in form
                    {
                        title: 'Select',
                        data: 'question_id',
                        render: function(data, type, row) {
                            // quite hard to set a checkbox to be checked
                            // var isTrue = false;
                            // 
                            //     for ($i = 0; $i < count($questionArr); $i++) {
                            //         $selectquestion = $questionArr[$i];
                            //         
                            //     var phpQuestion = parseInt(<php echo intval($selectquestion); ?>)
                            //     if (row.question_id === phpQuestion) {
                            //         isTrue = true;
                            //         break;
                            //     } else {
                            //         isTrue = false;
                            //     }
                            // <php
                            //     }
                            // ?>
                            // if (isTrue) {
                            //     return '<input class="chkbox"id="checkQu" name="inputQuestion[]" value="'+ row.question_id +'" type="checkbox" checked/>';
                            // } else {
                            //     return '<input class="chkbox"id="checkQu" name="inputQuestion[]" value="'+ row.question_id +'" type="checkbox"/>';
                            // }
                            return '<input class="chkbox"id="checkQu" name="inputQuestion[]" value="'+ row.question_id +'" type="checkbox"/>';
                            
                        }
                    },
                ]
            });
// I going to try this code out, was provided by ChatGPT
            // Initialize the DataTable inside the modal
            // var dataTable = $('#dataTable').DataTable({
            //     columns: [
            //         { data: 'column1' },
            //         { data: 'column2' },
            //         { data: 'checkboxData', render: function (data, type, row) {
            //             return '<input type="checkbox" ' + (row.column1 === data ? 'checked' : '') + '>';
            //         }}
            //     ]
            // });

            // // Populate the DataTable with data from PHP
            // var dataFromPHP = [
            //     { column1: 'Data 1', column2: 'Data 2', checkboxData: 'Data 1' },
            //     { column1: 'Data 3', column2: 'Data 4', checkboxData: 'Data 4' },
            //     // Add more data objects as needed
            // ];

            // dataTable.rows.add(dataFromPHP).draw();
        // });
        });

    // Add new input question field
        // $("#addField").click(function() {
        //     var questionType = $("#questionType").val();
        //     var inputFieldHtml = '<div><input id="displayQuestion" type="text" name="inputQuestion[]" placeholder="Enter Question ID" required><button type="button" class="removeField">Remove</button></div>';
        //     $("#inputQuestion").append(inputFieldHtml);
        // });

        // // Remove the selected input field
        // $(document).on("click", ".removeField", function() {
        //     $(this).parent('div').remove();
        // });

        // Get the modal
        var modal = document.getElementById("Create_Modal");

        // Get the input that opens the modal
        var btn = document.getElementById("displayQuestion");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the question input, open the modal 
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
    </script>
</html>