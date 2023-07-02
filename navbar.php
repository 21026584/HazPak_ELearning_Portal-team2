<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {

  // If user is not logged in, redirect to the login page
  header("Location: login.php");
  exit;
}

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
    <li <?php if ($currentPage == 'index.php') {
          echo 'class="custom-nav-item-active"';
        } else {
          echo 'class="custom-nav-item"';
        } ?>>
      <a href="index.php" class="custom-nav-link">Dashboard</a>
    </li>
    <!-- Check if user is Head Admin/Admin, before assigning specific nav items -->
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
    <?php } else { ?>
      <!-- Check if current page matches navigation item then sets class to active -->
      <li <?php if ($currentPage == 'grades.php') {
            echo 'class="custom-nav-item-active"';
          } else {
            echo 'class="custom-nav-item"';
          } ?>>
        <a href="grades.php" class="custom-nav-link">Grades</a>
      </li>
    <?php }
    ?>
    <!-- Check if current page matches navigation item then sets class to active -->
    <li <?php if (($currentPage == 'assessments.php') || ($currentPage == 'takeAssessment.php')) {
          echo 'class="custom-nav-item-active"';
        } else {
          echo 'class="custom-nav-item"';
        } ?>>
      <a href="assessments.php" class="custom-nav-link">Assessments</a>
    </li>
    <!-- Check if current page matches navigation item then sets class to active -->
    <li <?php if ($currentPage == 'exercises.php') {
          echo 'class="custom-nav-item-active"';
        } else {
          echo 'class="custom-nav-item"';
        } ?>>
      <a href="exercises.php" class="custom-nav-link">Exercises</a>
    </li>
    <!-- TEMPORARY LOG OUT -->
    <li class="custom-nav-item">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="logout" value="Log Out">
      </form>
    </li>
  </ul>
  <?php
  echo 'user_id: ' . $_SESSION['user_id'] . '<br>';
  echo 'role_id: ' . $userRoleID . '<br>';
  echo 'username: ' . $_SESSION['username'];
  ?>
</div>
<div style='margin-left: 280px'>