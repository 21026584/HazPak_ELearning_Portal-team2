<?php
// Include database connection
include("dbFunctions.php");

// Query
$query = "SELECT QB.question_id, QB.question_text, QT.type_name
    FROM question_bank AS QB
    INNER JOIN question_type AS QT
    ON QB.question_type_id = QT.type_id";
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
                <button onclick="redirectToPage('questionBank.php')">
                    Manage questions
                </button>
                <button onclick="redirectToPage('createQuestion.php')">
                    Create questions
                </button>
            </div>
            <!-- Datatable -->
            <main class="tableMain">
                <table id='exerciseTable' class="display">
                    <thead>
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
    </script>
</body>

</html>