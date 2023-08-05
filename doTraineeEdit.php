<?php
include("checkSession.php");
include ("dbFunctions.php");


$traineeID = $_POST['traineeID'];
$updatedID = $_POST['UpdatedTraineeID'];
$updateUsername = $_POST['UpdatedUsername'];
$updatePassword = $_POST['UpdatedTraineePassword'];


$queryUpdate = "UPDATE users,grades
                SET user_id='$updatedID'
                WHERE user_id='$traineeID'";
        
$resultUpdate = mysqli_query($link, $queryUpdate)
        or die(mysqli_error($link)); 

?>