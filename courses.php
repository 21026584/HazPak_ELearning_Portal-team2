<?php
include("checkSession.php");
include("dbFunctions.php");

$query = "SELECT U.user_id, U.username, U.intake, U.role_id
    FROM users AS U
    WHERE role_id = 2";
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
<style>
    
    </style>
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

            <div class="w3-container">
  <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Add Student</button>

  <div id="id01" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <p>Some text. Some text. Some text.</p>
        <p>Some text. Some text. Some text.</p>
      </div>
    </div>
  </div>
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
                            <td>Edit</td>
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
                        title: 'Edit',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="EditTrainee.php?user_id=' + row.user_id + '">Edit</a>';
                        }
                    }

                ]
            });
        });




        function redirectToPage(url) {
            window.location.href = url;
        }

                // Get the modal
        var modal = document.getElementById("id01");

        // Get the button that opens the modal
        var btn = document.getElementById("id01");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
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
</body>

</html>