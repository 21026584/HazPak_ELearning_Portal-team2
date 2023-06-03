<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "c203_p09";
$link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or 
        die(mysqli_connect_error());
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Grades</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <body>
    <div class="sidenav">

        <button class="dropdown-btn">Assessment 1
            <i class="fa-sharp fa-regular fa-arrow-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="#">Link 1</a>
          <a href="#">Link 2</a>
          <a href="#">Link 3</a>
        </div>
<br>
        <button class="dropdown-btn">Assessment 2
            <i class="fa-sharp fa-solid fa-arrow-down"></i>
          </button>
          <div class="dropdown-container">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
<br>
          <button class="dropdown-btn">Assessment 3
            <i class="fa-sharp fa-solid fa-arrow-down"></i>
          </button>
          <div class="dropdown-container">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
<br>

      </div>


</body>

<style>
/* Fixed sidenav, full height */
.sidenav {
  height: 100%;
  width: 500px;
position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
padding-left: 100px;
  /* overflow-x: hidden; */
  padding-top: 50px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  /* padding: 6px 8px 6px 16px; */
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width:100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #000000;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: rgb(255, 243, 8);
  color: rgb(0, 0, 0);
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #ffffff;
  padding-left: 8px;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}
</style>

<script>

  var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}


</script>
</html>