<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";
// FIX THE MODAL datatable, it is very funky

mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Create Admin</title>
</head>

<body>
    <h3>Create Admin</h3>
    <form id="postForm" method="post" action="doCreateAdmin.php">
    <input type="hidden" name="loginfirst" value="1">
    <label for="userID">User ID:</label>
    <input type="text" id="userID" name="userID" required />
    <br><br>
    <label for="roleID">Role:</label>
    <select name="roleID" id="roleID">
        <option value="1">Admin</option>
        <option value="0">Head Admin</option>
    </select>
    <br><br>
    <label for="userName">Username:</label>
    <input type="text" id="userName" name="userName" required />
    <br><br>
    <label for="password">Password:</label>
    <input type="text" id="password" name="password" value="Password" placeholder="'Password' is default" required />
    <br><br>
    <input type="submit" value="Create" />
    </form>
</body>

</html>