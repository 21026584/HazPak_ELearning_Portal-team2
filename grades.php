<?php
// Check user session
include("checkSession.php");
// Include navbar
include("navbar.php");

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "lp_db1";
$link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or 
        die(mysqli_connect_error());


 $query = "SELECT * FROM assessment_grade "
    ;
$result = mysqli_query($link, $query) or die(mysqli_error($link));

while ($row = mysqli_fetch_assoc($result)) {
  $arrItems[] = $row;
  $grade = $row['score'];
   $assessment = $row['assessment_id'];
   $user = $row['user_id'];
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


<div class="Course1">
    <button type="button" class="collapsible">Assessment 1</button>
    <div class="content">

      <?php
      if($assessment == 1 || $user = "T01"){
        echo $grade;
      }
      else{
        
      }
      ?>


    </div>
  </div>




  <div class="Assessment2">
    <button type="button" class="collapsible">Assessment 2</button>
    <div class="content">
      <?php  
      if($assessment == 2 And $user = "T01"){
        echo $grade;
      }
      else{
echo"";
      }
      ?>
      
    </div>
  </div>


  <div class="Assessment3">
    <button type="button" class="collapsible">Assessment 3</button>
    <div class="content">
      <?php  
      if($assessment == 3 And $user = "T01"){
        echo $grade;
      }
      else{
echo"";
      }
      ?>
      
    </div>
  </div>

  

</div>

<!-- <div>
<canvas id="myChart"></canvas> 
</div> -->

</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script>
  



var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}



</script>
</html>
