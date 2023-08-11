<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";
$roleID = $_SESSION['role_id'];

// Query to display only head admins or admins
$query = "SELECT user_id, username
    FROM users 
    WHERE role_id = 1 OR role_id = 0";
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
        <title>Admin</title>
    </head>

    <body>

        <?php
        // Show the admin-specific Assessment Page 
        if ($userRoleID == 0) {
        ?>
            <div class="tableRoot">
                <header class='tableHeader'>
                    <h1>Admin</h1>
                </header>
                <button onclick="redirectToPage('createAdmin.php')">Create Admins</button>
                <!-- Datatable -->
                <main class="tableMain">
                    <table id='assessmentTable' class="">
                        <thead>
                            <tr>
                                <!-- Headers -->
                                <td>Admin ID</td>
                                <td>username</td>
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
        }
        ?>

        <!-- Datatable.js -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Initialise DataTable
            $(document).ready(function() {
                // Compile database rows into json
                var jsonData = <?php echo $jsonData; ?>;
                $('#assessmentTable').DataTable({
                    data: jsonData,
                    columns: [{
                            title: 'Admin ID',
                            data: 'user_id'
                        },
                        {
                            title: 'Username',
                            data: 'username'
                        },
                        {
                            title: 'Edit',
                            data: null,
                            render: function(data, type, row) {
                                return '<a href="adminEdit.php?username=' + row.username + '" class="">Edit</a>';
                            }
                        },
                        // Use assessment_id for indicated assessment to delete
                        {
                            title: 'Delete',
                            data: null,
                            render: function(data, type, row) {
                                return '<button onclick="confirmDel('+ row.user_id +')">Delete</button>';
                            }
                        }
                    ]
                });
            });

            // will confirm whether admins want to delete that assessment
            function confirmDel(url) {
                var confirmation = window.confirm("Are you sure you want to delete this Admin?");
                alert("Delete button clicked for user ID: " + url);
                if (confirmation) {
                    // If user clicked "OK", redirect to assessmentDelete.php
                    window.location.href = "adminDelete.php?user_id="+url;
                } else {
                    // If user clicked "Cancel", alert message appear and nothing else happen
                    alert(url+" was not deleted");
                }
            }
        </script>
    </body>

</html>