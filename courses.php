<?php
include("dbFunctions.php");

$query = "SELECT U.user_id, U.username, U.intake
    FROM users AS U
    WHERE role_id=2";
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
    
    <title>Courses</title>
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
                <h1>Courses</h1>
            </header>
            <div class="assessmentButtonContainer">
                <button id="Add_Button">Add student button</button>
            </div>

            <!-- Datatable -->
            <main class="tableMain">
                <table id='exerciseTable' class="display table-striped">
                    <thead class="table-header">
                        <tr>
                            <!-- Headers -->
                            <td>Student ID</td>
                            <td>Student Name</td>
                            <td>Intake</td>
                            <td>Add</td>
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
</body>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialise DataTable
        $(document).ready(function() {
            // Compile database rows into json
            var jsonData = <?php echo $jsonData; ?>;
            $('#exerciseTable').DataTable({
                data: jsonData,
                columns: [{
                        title: 'Student ID',
                        data: 'user_id'
                    },
                    {
                        title: 'Student Name',
                        data: 'username'
                    },
                    {
                        title: 'Intake',
                        data: 'intake'
                    },
                    {
                        title: 'Add',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="AddTrainee.php?user_id=' + row.user_id + '">Add</a>';
                        }
                    }

                ]
            });
        });
       
    </script>
</body>

</html>