<?php
session_start();
//php file that allows admins to create, edit, or delete new trainee (Only super admin can manage other admins account)

include("dbFunctions.php");
//query retrieve information on members
$queryMembers = "SELECT u.user_id, u.username, u.password, r.role_name
            FROM users u, roles r
            WHERE u.role_id = r.role_id";
            // Connects the users data table with the roles data table through the role_id that are in both data table
//role_id is datatype is Int, 0 is Head admin, 1 is admin, 2 is trainee
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
    <link rel="stylesheet" href="style.css">
    <title>Members Edit</title>
</head>

<body>
    <!-- table will contain info on Admins and Trainee which can be created, edited, or deleted depending on the admin -->
</body>

</html>