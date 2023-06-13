<?php
// php file that contains the common database connection code
include "dbFunctions.php";

if (!empty($_POST['quType'])) {
    //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
    $name = $_POST['quType'];
}
// Closes the Database conection 
mysqli_close($link);
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
    <title>Create Assessment</title>
</head>

<body>
    <p>
        <?php 
        echo $name;
        ?>
    </p>
</body>

</html>