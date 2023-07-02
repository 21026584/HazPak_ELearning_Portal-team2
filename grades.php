<?php
include "navbar.php";
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "lp_db1";
$link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or 
        die(mysqli_connect_error());


/*  $queryMembers = "SELECT u.user_id, u.username, u.password, r.role_name
        FROM users u, roles r
        WHERE u.role_id = r.role_id"; */

/* $results = mysqli_query($link, $queryMembers) or die(mysqli_error($link));

while ($row = mysqli_fetch_assoc($results)) {
$arrItems[] = $row;
}
mysqli_close($link);
 */
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


<div class="Course1">
    <button type="button" class="collapsible">Assessment 1</button>
    <div class="content">
      <a class="assessment-anchor" href="">

      </a>
      <a class="assessment-anchor" href="">

      </a>
    </div>
  </div>

  <div class="Assessment2">
    <button type="button" class="collapsible">Assessment 2</button>
    <div class="content">
      <a class="assessment-anchor" href="">
        
      </a>
      <a class="assessment-anchor" href="">
 
      </a>
    </div>
  </div>


  <div class="Assessment3">
    <button type="button" class="collapsible">Assessment 3</button>
    <div class="content">
      <a class="assessment-anchor" href="">

      </a>
      <a class="assessment-anchor" href="">

      </a>
    </div>
  </div>


</div>

<div>
<canvas id="myChart"></canvas> 
</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script>
  


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
