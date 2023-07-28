<?php
include ("dbFunctions.php");
$updatedID = $_POST['traineeID'];
$updateUsername = $_POST['idUsername'];
$updatePassword = $_POST['traineePassword'];

$queryUpdate = "UPDATE users
                SET user_id='$updatedID'
                WHERE id = $theID";

$resultUpdate = mysqli_query($link, $queryUpdate)
        or die(mysqli_error($link));

?>