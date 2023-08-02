

<?php

// Check if the user clicked the log out button
if (isset($_POST['logout'])) {
  // Clear all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Redirect the user to the login page
  header("Location: login.php");
  exit();
}

// check if user logins in for the first time
// ($_SESSION['role_id']== 1))|| for admin to change password
if (($_SESSION['firstLogin'] == 1) && ($_SESSION['role_id']== 2)) {
  //redirects them to a separate page to change their password
  header("Location: changePassword.php");
  exit();
} 

// Assign session user id to a variable
$userRoleID = $_SESSION['role_id'];
?>
<!-- Store current page url -->
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<div class="d-flex flex-column side-bar">
  <!-- Logo -->
  <div class="logoContainer">
    <img src='Images/HazPakLogo.png' class="logo">
  </div>
  <!-- Navigation items -->
  <ul class="nav flex-column mb-auto">
    <!-- Check if current page matches navigation item then sets class to active -->

    <!-- Check if user is Head Admin/Admin, before assigning specific nav items -->


    <li <?php if ($currentPage == 'index.php') {
          echo 'class="custom-nav-item-active"';
        } else {
          echo 'class="custom-nav-item"';
        } ?>>
      <a href="index.php" class="custom-nav-link">Dashboard</a>
    </li>
    

    <?php
    if ($userRoleID == 0 || $userRoleID == 1) {
    ?>
      <!-- Check if current page matches navigation item then sets class to active -->

      <li <?php if ($currentPage == 'questionBank.php') {
            echo 'class="custom-nav-item-active"';
          } else {
            echo 'class="custom-nav-item"';
          } ?>>
        <a href="questionBank.php" class="custom-nav-link">Question Bank</a>
      </li>

      <!-- Check if current page matches navigation item then sets class to active -->


<?php } ?>


    <li <?php if ($currentPage == 'exercises.php') {
          echo 'class="custom-nav-item-active"';
        } else {
          echo 'class="custom-nav-item"';
        } ?>>
      <a href="exercises.php" class="custom-nav-link">Exercises</a>
      
    </li>

    <li <?php if (($currentPage == 'assessments.php') || ($currentPage == 'takeAssessment.php')) {
          echo 'class="custom-nav-item-active"';
        } else {
          echo 'class="custom-nav-item"';
        } ?>>
      <a href="assessments.php" class="custom-nav-link">Assessments</a>
    </li>
    

    <?php
    if ($userRoleID == 0 || $userRoleID == 1) {
    ?>
      <!-- Check if current page matches navigation item then sets class to active -->

      

    <li <?php if ($currentPage == 'courses.php') {
            echo 'class="custom-nav-item-active"';
          } else {
            echo 'class="custom-nav-item"';
          } ?>>
        <a href="courses.php" class="custom-nav-link">Courses</a>
      </li>


      <!-- Check if current page matches navigation item then sets class to active -->


<?php } ?>




<?php
    if ($userRoleID == 2) {
    ?>
      <!-- Check if current page matches navigation item then sets class to active -->


      <li <?php if ($currentPage == 'grades.php') {
            echo 'class="custom-nav-item-active"';
          } else {
            echo 'class="custom-nav-item"';
          } ?>>
        <a href="grades.php" class="custom-nav-link">Grades</a>
      </li>
      <!-- Check if current page matches navigation item then sets class to active -->


<?php } ?>


    <!-- TEMPORARY LOG OUT -->
    <li class="custom-nav-item">
       <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <input type="submit" class="button" name="logout" value="Log Out">
  
      </form> 
    </li>
  </ul>
  <?php
  echo 'user_id: ' . $_SESSION['user_id'] . '<br>';
  echo 'firstLogin: ' . $_SESSION['firstLogin'] . '<br>';
  echo 'role_id: ' . $userRoleID . '<br>';
  echo 'username: ' . $_SESSION['username'];
  ?>
</div>

<div style='margin-left: 280px; width:100%'>

<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
  .button{
        background-color: #f44336;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
      }
</style>