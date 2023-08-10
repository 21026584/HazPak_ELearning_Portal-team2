<?php
include("checkSession.php");
include ("dbFunctions.php");


$traineeID = $_POST['traineeID'];
$updatedUsername = $_POST['UpdatedUsername'];
$updatedPassword = $_POST['UpdatedTraineePassword'];
$UpdatedIntake = $_POST['UpdatedIntake'];

$queryUpdate = "UPDATE users
                SET username='$updatedUsername', password=SHA1('$updatedPassword'), intake='$UpdatedIntake'
                WHERE user_id='$traineeID'";
        
$resultUpdate = mysqli_query($link, $queryUpdate)
        or die(mysqli_error($link)); 

?>