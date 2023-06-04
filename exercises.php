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

    // Navbar
    include "navbar.php";
    ?>
    <div class="assessmentRoot">
        <header class='assessmentHeader'>
            <h1>Exercises</h1>
        </header>
        <div class="assessmentButtonContainer">
            <button>
                Manage exercises
            </button>
            <button>
                Create exercises
            </button>
        </div>
        <!-- Datatable -->
        <main class="assessmentMain">
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
                            return '<a href="exerciseDelete.php?exercise_id=' + row.exercise_id + '">Delete</a>';
                        }
                    }
                ]
            });
        });
    </script>
</body>

</html>