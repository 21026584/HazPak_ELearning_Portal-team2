<!DOCTYPE html>
<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="navbar.css">
  <title>Dashboard</title>
</head>

<body>
  <?php
  // Start the session
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {

    // If user is not logged in, redirect to the login page
    header("Location: login.php");
    exit;
  }

  // Assign session user id to a variable
  $userRoleID = $_SESSION['user_id'];

  // Navbar
  include "navbar.php";

  // Display session
  echo 'User ID: ' . $_SESSION['user_id'] . '<br>';
  echo 'Username: ' . $_SESSION['username'] . '<br>';
  echo 'Role ID: ' . $_SESSION['role_id'];
  ?>
  <div class='root'>

  </div>
</body>

</html>