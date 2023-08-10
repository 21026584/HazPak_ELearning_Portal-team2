<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");

// Query
$query = "SELECT E.exercise_id, E.exercise_name, E.instructions, E.release_datetime, U.username
    FROM exercises AS E
    INNER JOIN users AS U
    ON U.user_id = E.user_id";
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

$result->data_seek(0);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Exercises</title>
</head>

<body>
    <?php
    // Navbar
    include "navbar.php";

    // Show the admin-specific Exercise Page 
    if (($userRoleID == 0) || ($userRoleID == 1)) {
    ?>
        <div class="tableRoot">
            <header class='tableHeader'>
                <h1>Exercises</h1>
            </header>
            <div class="assessmentButtonContainer">
                <button onclick="redirectToPage('createExercise.php')">
                    Create exercises
                </button>
            </div>
            <!-- Datatable -->
            <main class="tableMain">
                <table id='exerciseTable' class="display">
                    <thead>
                        <tr>
                            <!-- Headers -->
                            <td>Course ID</td>
                            <td>exercise Name</td>
                            <td>Release Datetime</td>
                            <td>Created By</td>
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
        // Show the trainee Exercise Page 
    } else if ($userRoleID == 2) { ?>
        <div class="assessment-details-dropdown-container">
            <select class="assessment-details-dropdown" name="pets" id="pet-select">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $exerciseName = $row["exercise_name"];
                        $exerciseId = $row["exercise_id"];
                        echo "<option value='$exerciseId'>$exerciseName</option>";
                    }
                }
                if (!empty($data)) {
                    $firstRow = $data[0];
                    $exerciseId = $firstRow['exercise_id'];
                    $exerciseName = $firstRow['exercise_name'];
                    $instructions = $firstRow['instructions'];
                    $releaseTime = $firstRow['release_datetime'];
                    $createdBy = $firstRow['username'];
                } else {
                    echo "No rows found in the data array.";
                }
                ?>
            </select>
        </div>
        <div id="exerciseDetails" class="assessment-details-root">
            <div class="assessment-details-header">
                <?php echo $exerciseName; ?>
            </div>
            <div class="assessment-details-body">
                <div>
                    Start Time: <?php echo $releaseTime; ?>
                </div>
                <div style="margin-top: 3em;">
                    Description:
                </div>
                <div style="font-weight: normal;">
                    <?php echo $instructions; ?>
                </div>
                <div style="margin-top: 3em;">
                    Created by: <?php echo $createdBy; ?>
                </div>
                <div class="assessment-details-button-container">
                    <a href="takeExercise.php?exercise_id=<?php echo $exerciseId; ?>" class="start-assessment-button">Start</a>
                </div>
            </div>
        </div>
    <?php
    }
    // Close the database connection
    $result->data_seek(0);
    mysqli_close($link);
    ?>
    <!-- Datatable.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

    <script>
        // Initialise DataTable
        $(document).ready(function() {
            // Compile database rows into json
            var jsonData = <?php echo $jsonData; ?>;
            $('#exerciseTable').DataTable({
                data: jsonData,
                columns: [{
                        title: 'Exercise ID',
                        data: 'exercise_id'
                    },
                    {
                        title: 'Exercise Name',
                        data: 'exercise_name'
                    },
                    {
                        title: 'Release Datetime',
                        data: 'release_datetime'
                    },
                    {
                        title: 'Created By',
                        data: 'username'
                    },
                    // Use exercise_id to indicated exercise to edit
                    {
                        title: 'Edit',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="exerciseEdit.php?exercise_id=' + row.exercise_id + '">Edit</a>';
                        }
                    },
                    // Use exercise_id to indicated exercise to delete
                    {
                        title: 'Delete',
                        data: null,
                        render: function(data, type, row) {
                            return '<button onclick="confirmDel('+ row.exercise_id +')">Delete</button>';
                        }
                    }
                ]
            });
        });
        // Redirects the user to the specified URL
        function redirectToPage(url) {
            window.location.href = url;
        }

        $(document).ready(function() {
            $('#pet-select').change(function() {
                var exerciseId = $(this).val();

                // Send an AJAX request to a PHP script that retrieves assessment details
                $.ajax({
                    url: 'getExerciseDetails.php',
                    type: 'POST',
                    data: {
                        exerciseId: exerciseId
                    },
                    success: function(response) {
                        // Update the content of the assessmentDetailsContainer with the response
                        $('#exerciseDetails').html(response);
                    },

                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        // will confirm whether admins want to delete that assessment
        function confirmDel(url) {
            var confirmation = window.confirm("Are you sure you want to delete this Exercise?");
  
            if (confirmation) {
                // If user clicked "OK", redirect to assessmentDelete.php
                window.location.href = "exerciseDelete.php?exercise_id="+url;
            } else {
                // If user clicked "Cancel", alert message appear and nothing else happen
                alert(url+" was not deleted");
            }
        }
    </script>
</body>

</html>