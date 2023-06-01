<!DOCTYPE html>
<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="sidebar.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="dashboard-style.css">
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
  ?>
  <div>
    <?php
    // Navbar
    include "navbar.php";
    ?></div>
  <div style='margin-left: 240px'>
    <div class="container">
      <h1 class="header">
        Dashboard
      </h1>
      <div class="account">
        <h4>account</h4>
        <a>
          <img id="circle" src="https://images.unsplash.com/photo-1515266591878-f93e32bc5937?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGJsdWV8ZW58MHx8MHx8&auto=format&fit=crop&w=800&q=70">
        </a>
      </div>
    </div>
    <div class="container">
      <div class="block block-left">
        <h2>Available Assessments</h2>
        <div class="scroll-menu">
          <a><img class="image" src="images/image 2.jpeg" draggable="false" />
            <h4 class="i-caption">image 1</h4>
          </a>
        </div>
      </div>
      <div class="block block-right">
        <h2>Schedule</h2>
      </div>
    </div>
    <div class="container">
      <div class="block block-left">
        <h2>Available Exercises</h2>
        <div class="scroll-menu">
          <a><img class="image" src="images/image 2.jpeg" draggable="false" />
            <h4 class="i-caption">image 1</h4>
          </a>
        </div>
      </div>
      <div class="block block-right">
        <h2>Announcements</h2>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>