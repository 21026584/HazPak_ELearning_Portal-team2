<?php
include("checkSession.php");
include("dbFunctions.php");

$query = "SELECT U.user_id, U.username, U.intake, U.role_id, G.course_id, A.assessment_name
    FROM users AS U
    INNER JOIN grades AS G 
    ON U.user_id = G.user_id
    INNER JOIN assessments AS A
    ON G.course_id = A.course_id
    WHERE U.role_id = 2";
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
.tableMain{
    width: 110%;
}

body{
    position: fixed;
}

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal2 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.modal-content2 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
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
      

            <button id="myBtn">Add Trainee</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
 
    <form id="AddTraineeForm" method="post" action="doAddTrainee.php">
        <label for="idUsername">Username:</label>
        <input type="text" id="idUsername" name="idUsername" required />
        <br>
        <label for="traineeID">Trainee ID:</label>
        <input type="text" id="traineeID" name="traineeID" required />
        <br>
        <label for="traineePassword">Password:</label>
        <input type="text" id="traineePassword" name="traineePassword" required />
        <br>
        <label for="intake">Intake:</label>
        <input type="text" id="intake" name="intake" required />
        <br>
        <input type="submit" value="Add" />
    </form> 
  </div>

</div>



<button id="myBtn2">Add Course</button>

<!-- The Modal -->
<div id="myModal2" class="modal2">

  <!-- Modal content -->
  <div class="modal-content2">
    <span class="close">&times;</span>

    <form id="AddCourseForm" method="post" action="doAddCourse.php">
        <label for="courseId">Course Id:</label>
        <input type="text" id="courseId" name="courseId" required />
        <br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required />
    <br>
        <input type="submit" value="Add" />
    </form>

  </div>

</div>


            <!-- Datatable -->
            <main class="tableMain">
                <table id='exerciseTable' class="display table-striped data-table">
                    <thead class="table-header">
                        <tr>
                            <!-- Headers -->
                            <td>Course ID</td>
                            <td>Assessment</td>
                            <td>Student ID</td>
                            <td>Student Name</td>
                            <td>Intake</td>
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
                        title: 'Course ID',
                        data: 'course_id'
                    },
                    {
                        title: 'Assessment',
                        data: 'assessment_name'
                    },
                    {
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
                    },
                    {
                        title: 'Delete',
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="deleteTrainee.php?user_id=' + row.user_id + '">Delete</a>';
                        }
                    }

                ]
            });
        });


        // Event listener for the "Delete" links
        $(document).on('click', 'a[data-action="delete"]', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');

            // Send AJAX request to deleteTrainee.php
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Refresh the DataTable after successful deletion
                        $('#exerciseTable').DataTable().ajax.reload();
                    } else {
                        // Handle deletion error, show an alert or message if needed
                        alert('Failed to delete trainee. Please try again.');
                    }
                },
                error: function() {
                    // Handle AJAX error, show an alert or message if needed
                    alert('An error occurred while processing your request. Please try again.');
                }
            });
        });


// Get the modal
var modal = document.getElementById("myModal2");

// Get the button that opens the modal
var btn = document.getElementById("myBtn2");

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


// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

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