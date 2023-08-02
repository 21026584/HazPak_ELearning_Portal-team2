<?php
include("checkSession.php");
include ("dbFunctions.php");



$queryItem = "SELECT * FROM users";

$resultItem = mysqli_query($link, $queryItem) or 
die(mysqli_error($link)); 


$updatedID = $_POST['UpdatedTraineeID'];
$updateUsername = $_POST['UpdatedUsername'];
$updatePassword = $_POST['UpdatedTraineePassword'];




$queryUpdate = "UPDATE users
                SET user_id='$updatedID'";
        
$resultUpdate = mysqli_query($link, $queryUpdate)
        or die(mysqli_error($link));

?>