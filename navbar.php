<!--
<div class='side-bar'>
  <ul class="">
    <li><a href="#">Link 1</a></li>
    <li><a href="#">Link 2</a></li>
    <li><a href="#">Link 3</a></li>
  </ul>
  <nav id="nav-bar" class="collapse d-lg-block sidebar collapse">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <a class="list-group-item list-group-item-action py-2 ripple" href="dashboard.php">Dashboard</a>
        <a class="list-group-item list-group-item-action py-2 ripple" href="#">Assessments</a>
        <?php
        /*
        if ($_SESSION['role_id'] == 0 || $_SESSION['role_id'] == 1) {
        ?>
          <a class="list-group-item list-group-item-action py-2 ripple" href="questionBank.php">Question Bank</a>
        <?php } else { ?>
          <a class="list-group-item list-group-item-action py-2 ripple" href="grades.php">Grades</a>
        <?php } 
        */
        ?>
      </div>
    </div>
  </nav>
</div>
-->

<div class="d-flex flex-column flex-grow-0 p-3 shadow-lg" style="width: 280px; background: green; height: 100vh">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="#" class="nav-link active" aria-current="page">
          Home
        </a>
      </li>
      <li>
        <a href="#" class="nav-link link-body-emphasis">
          Dashboard
        </a>
      </li>
      <li>
        <a href="#" class="nav-link link-body-emphasis">
          Orders
        </a>
      </li>
      <li>
        <a href="#" class="nav-link link-body-emphasis">
          Products
        </a>
      </li>
      <li>
        <a href="#" class="nav-link link-body-emphasis">
          Customers
        </a>
      </li>
    </ul>
    <hr>
  </div>