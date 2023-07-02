<?php
include "navbar.php";
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "lp_db1";
$link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or 
        die(mysqli_connect_error());


 $query = "SELECT G.description, G.grade
    FROM grades AS G
    INNER JOIN users AS U
    INNER JOIN courses AS C
    ON U.user_id = G.user_id AND C.course_id = G.course_id"
    ;
$result = mysqli_query($link, $query) or die(mysqli_error($link));

while ($row = mysqli_fetch_assoc($result)) {
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
     <link rel="stylesheet" href="dashboard-style.css">
     <link rel="stylesheet" href="style.css">
    <title> grades </title>
</head>

 <body>

 <div class="grades">

 <div class="dropdown">
  <button class="dropbtn">Assessment 1       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
</svg> </i> </button>

  <div class="dropdown-content">
  <a href="#">Pass</a>
  </div>
</div>
<br>
<br>

<div class="dropdown">
  <button class="dropbtn">Assessment 2   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
</svg></button>
  <div class="dropdown-content">
  <a href="#">Pass</a>
  </div>
</div>

<br>
<br>

<div class="dropdown">
  <button class="dropbtn">Assessment 3      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
</svg></button>
  <div class="dropdown-content">
  <a href="#">Fail</a>
  </div>
</div>




</div>

<div>
<canvas id="myChart"></canvas> 
</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

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



const labels = [
     'Pass',
     'Fail',
    ];


   const data = {
     labels: labels,
     datasets: [{
       label: 'Dataset',
       backgroundColor: [ 
       'rgb(255, 99, 132)', 
       'rgb(54, 162, 235)',

     ],
       data: [2,1],
    }]
   };

    const config = {
    type: 'bar',
   data: data
      };

        const myChart = new Chart(
      document.getElementById('myChart'),
        config
     );


</script>
</html>
