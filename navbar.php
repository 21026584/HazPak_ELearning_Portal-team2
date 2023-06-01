<!-- Store current page url -->
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<div class="d-flex flex-column shadow-lg side-bar">
  <!-- Logo -->
  <div class="logoContainer">
    <img src='Images/HazPakLogo.png' class="logo">
  </div>
  <!-- Navigation items -->
  <ul class="nav flex-column mb-auto">
    <!-- Check if current page matches navigation item then sets class to active -->
    <li <?php if ($currentPage == 'index.php') { echo 'class="custom-nav-item-active"'; } else { echo 'class="custom-nav-item"'; } ?>>
      <a href="index.php" class="custom-nav-link">Dashboard</a>
    </li>
    <!-- Check if user is Head Admin/Admin, before assigning specific nav items -->
    <?php
    if ($_SESSION['role_id'] == 0 || $_SESSION['role_id'] == 1) {
    ?>
    <!-- Check if current page matches navigation item then sets class to active -->
    <li <?php if ($currentPage == 'questionBank.php') { echo 'class="custom-nav-item-active"'; } else { echo 'class="custom-nav-item"'; } ?>>
      <a href="questionBank.php" class="custom-nav-link">Question Bank</a>
    </li>
    <?php } else { ?>
      <!-- Check if current page matches navigation item then sets class to active -->
      <li <?php if ($currentPage == 'grades.php') { echo 'class="custom-nav-item-active"'; } else { echo 'class="custom-nav-item"'; } ?>>
      <a href="grades.php" class="custom-nav-link">Grades</a>
      </li>
    <?php }
    ?>
    <!-- Check if current page matches navigation item then sets class to active -->
    <li <?php if ($currentPage == 'assessments.php') { echo 'class="custom-nav-item-active"'; } else { echo 'class="custom-nav-item"'; } ?>>
      <a href="assessments.php" class="custom-nav-link">Assessments</a>
    </li>
    <!-- Check if current page matches navigation item then sets class to active -->
    <li <?php if ($currentPage == 'exercises.php') { echo 'class="custom-nav-item-active"'; } else { echo 'class="custom-nav-item"'; } ?>>
      <a href="exercises.php" class="custom-nav-link">Exercises</a>
    </li>
  </ul>