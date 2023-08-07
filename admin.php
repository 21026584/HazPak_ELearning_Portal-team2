<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";
$roleID = $_SESSION['role_id'];

// Query 
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
                <div class="adminButtonContainer">
                <button id="Create_Button">Create Admins</button>
                </div>
                <div id="Create_Modal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                    <span class="close">&times;</span>
                    <h1>Create Admin</h1>
                    <form  id="postForm" method="post" action="doAssessmentEdit.php">
                        <input type="hidden" name="roleID" value="1"/>
                        <input type="hidden" name="login" value="1"/>
                        <label for="userID">User ID:</label>
                        <input type="text" id="userID" name="userID" required />
                        <br><br>
                        <label for="userName">Username:</label>
                        <input type="text" id="" name="" required />
                        <br><br>
                        <label for="password">Password:</label>
                        <input type="text" id="password" name="password" value="Password" placeholder="'Password' is default" required />
                    </form>
                    </div>
                </div>
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
                                return '<a href="adminEdit.php?user_id=' + row.user_id + '" class="">Edit</a>';
                            }
                        },
                        // Use assessment_id for indicated assessment to delete
                        {
                            title: 'Delete',
                            data: null,
                            render: function(data, type, row) {
                                return '<a href="adminDelete.php?user_id=' + row.user_id + '" onclick="confirmDel()">Delete</a>';
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
                });
            });

        // Get the modal
        var modal = document.getElementById("Create_Modal");

        // Get the input that opens the modal
        var btn = document.getElementById("Create_Button");

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

        function confirmDel() {
            //Couldn't get the assessment name due to the modal structure
            confirm("Are you sure you want to delete this Admin?");
        }
        </script>
    </body>

</html>