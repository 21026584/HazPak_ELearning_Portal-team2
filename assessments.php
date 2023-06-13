<?php
// Include database connection
include("dbFunctions.php");

// Query 
$query = "SELECT assessment_id, assessment_name, instructions, release_datetime, username
    FROM assessments AS A
    INNER JOIN users AS U
    ON U.user_id = A.user_id";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

// Initialise values
$data = array();

// Fetching user info from database
if (mysqli_num_rows($result) == 1) {
    while ($row = $result->fetch_assoc()) {
        // Add each row to the data array
        $data[] = $row;
    }
}

// Close the database connection
mysqli_close($link);

// Convert the data to JSON format
$jsonData = json_encode($data);
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
                <button onclick="redirectToPage('assessments.php')">
                    Manage Assessments
                </button>
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
        <div class="assess_container">
            <select class="assessments" name="pets" id="pet-select">
                <option value="assessment1">Assessment 1</option>
                <option value="assessment2">Assessment 2</option>
                <option value="assessment3">Assessment 3</option>
                <option value="assessment4">Assessment 4</option>
                <option value="assessment5">Assessment 5</option>
                <option value="assessment6">Assessment 6</option>
                <option value="assessment7">Assessment 7</option>
                <option value="assessment8">Assessment 8</option>
            </select>
        </div>
        <div class="assessmentOverview">
            <div class="assessmentHeader">
                DETAILS
            </div>
            <div class="assessmentBody">

            </div>

        </div>
    <?php } ?>
    <div class="acc_container">
        <div class="account">
            <h4>account</h4>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp=ygUXbmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXA%3D">
                <img id="circle" src="https://images.unsplash.com/photo-1515266591878-f93e32bc5937?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGJsdWV8ZW58MHx8MHx8&auto=format&fit=crop&w=800&q=70">
            </a>
        </div>
    </div>

    <div class="detail-container">
        <div class="A-header">Details</div>
        <div class="A-details"><p></P><button class="start-assessment-button"></button></div>
    </div>
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
                            return '<a href="assessmentDelete.php?assessment_id=' + row.assessment_id + '">Delete</a>';
                        }
                    }
                ]
            });
        });
        // Redirects the user to the specified URL
        function redirectToPage(url) {
            window.location.href = url;
        }
    </script>
</body>

</html>