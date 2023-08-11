<?php
// Check user session
include("checkSession.php");
// Include database connection
include("dbFunctions.php");

// Query 
$query = "SELECT A.assessment_id, A.assessment_name, A.instructions, A.release_datetime, U.username
    FROM assessments AS A
    INNER JOIN users AS U
    ON U.user_id = A.user_id";
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
    <title>Assessments</title>
</head>

<body>

    <?php
    // Navbar
    include "navbar.php";

    // Show the admin-specific Assessment Page 
    if (($userRoleID == 0) || ($userRoleID == 1)) {
    ?>
        <div class="tableRoot">
            <header class='tableHeader'>
                <h1>Assessments</h1>
            </header>
            <div class="assessmentButtonContainer">
                <button onclick="redirectToPage('createAssessment.php')">
                    Create Assessments
                </button>
            </div>
            <!-- Datatable -->
            <main class="tableMain">
                <table id='assessmentTable' class="">
                    <thead>
                        <tr>
                            <!-- Headers -->
                            <td>Course ID</td>
                            <td>Assessment Name</td>
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
        // Show the trainee Assessment Page 
    } else if ($userRoleID == 2) {
    ?>
        <div class="assessment-details-dropdown-container">
            <select class="assessment-details-dropdown" name="pets" id="pet-select">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $assessmentName = $row["assessment_name"];
                        $assessmentId = $row["assessment_id"];
                        echo "<option value='$assessmentId'>$assessmentName</option>";
                    }
                }
                if (!empty($data)) {
                    $firstRow = $data[0];
                    $assessmentName = $firstRow['assessment_name'];
                    $assessmentId = $firstRow['assessment_id'];
                    $instructions = $firstRow['instructions'];
                    $releaseTime = $firstRow['release_datetime'];
                    $createdBy = $firstRow['username'];
                } else {
                    echo "No rows found in the data array.";
                }
                ?>
            </select>
        </div>
        <div id="assessmentDetails" class="assessment-details-root">
            <div class="assessment-details-header">
                <?php echo $assessmentName; ?>
            </div>
            <div class="assessment-details-body">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        Start Time: <?php echo $releaseTime; ?>
                    </div>
                    <div>
                        Time Taken: -
                    </div>
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
                    <a href="takeAssessment.php?assessment_id=<?php echo $assessmentId; ?>" class="start-assessment-button">Start</a>
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
            $('#assessmentTable').DataTable({
                data: jsonData,
                columns: [{
                        title: 'Assessment ID',
                        data: 'assessment_id'
                    },
                    {
                        title: 'Assessment Name',
                        data: 'assessment_name'
                    },
                    {
                        title: 'Release Datetime',
                        data: 'release_datetime'
                    },
                    {
                        title: 'Created By',
                        data: 'username'
                    },
                    // Use assessment_id for indicated assessment to edit
                    {
                        title: 'Edit',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="assessmentEdit.php?assessment_id=' + row.assessment_id + '" class="">Edit</a>';
                        }
                    },
                    // Use assessment_id for indicated assessment to delete
                    {
                        title: 'Delete',
                        data: null,
                        render: function(data, type, row) {
                            return '<button onclick="confirmDel(' + row.assessment_id + ')">Delete</button>';
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
                var assessmentId = $(this).val();

                // Send an AJAX request to a PHP script that retrieves assessment details
                $.ajax({
                    url: 'getAssessmentDetails.php',
                    type: 'POST',
                    data: {
                        assessmentId: assessmentId
                    },
                    success: function(response) {
                        // Update the content of the assessmentDetailsContainer with the response
                        $('#assessmentDetails').html(response);
                    },

                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
                const newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
                window.history.pushState({}, '', newUrl);
            });
        });

        // Get the URL parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Check if a specific parameter exists
        if (urlParams.has('assessment_id')) {
            // Parameter 'assessment_id' exists in the URL
            const assessment_id = urlParams.get('assessment_id');
            $(document).ready(function() {
                // Desired value to select
                const value = assessment_id;

                // Select the desired option by setting the value of the select element
                $('#pet-select').val(value);

                // Add the "selected" attribute to the desired option
                $('#pet-select option[value="' + value + '"]').prop('selected', true);
            });
            // Send an AJAX request to a PHP script that retrieves assessment details
            $.ajax({
                url: 'getAssessmentDetails.php',
                type: 'POST',
                data: {
                    assessmentId: assessment_id
                },
                success: function(response) {
                    // Update the content of the assessmentDetailsContainer with the response
                    $('#assessmentDetails').html(response);
                },

                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        // will confirm whether admins want to delete that assessment
        function confirmDel(url) {
            var confirmation = window.confirm("Are you sure you want to delete this Assessment?");

            if (confirmation) {
                // If user clicked "OK", redirect to assessmentDelete.php
                window.location.href = "assessmentDelete.php?assessment_id=" + url;
            } else {
                // If user clicked "Cancel", alert message appear and nothing else happen
                alert(url + " was not deleted");
            }
        }
    </script>
</body>

</html>