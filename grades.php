<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "lp_db1";
$link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or 
        die(mysqli_connect_error());


 $queryMembers = "SELECT u.user_id, u.username, u.password, r.role_name
        FROM users u, roles r
        WHERE u.role_id = r.role_id";

$results = mysqli_query($link, $queryMembers) or die(mysqli_error($link));

while ($row = mysqli_fetch_assoc($results)) {
$arrItems[] = $row;
}
mysqli_close($link);

?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>grades</title>
</head>

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


<div>
<canvas id="myChart"></canvas> 
</div>

</body>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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


const data = {
labels: $queryMembers,
datasets: [{
label: 'My First Dataset',
backgroundColor: 'rgb(255, 99, 132)',
borderColor: 'rgb(255, 99, 132)',
data: [5, 10, 5, 2, 20, 30],
}]
};

const config = {
type: 'bar',
data: data
};

const labels = [
'January',
'February',
'March',
'April',
'May',
'June'
];

const myChart = new Chart(
document.getElementById('myChart'),
config
);

</script>
</html>
