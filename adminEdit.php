<?php
// php file that contains the common database connection code
include "dbFunctions.php";
// Check user session
include("checkSession.php");
// Navbar
include "navbar.php";

$userName = $_GET['username'];

// create query to retrieve a single record based on the value of $userID 
$queryItem = "SELECT * FROM users
          WHERE `username` = '$userName'";

// execute the query
$resultItem = mysqli_query($link, $queryItem) or die(mysqli_error($link));

// fetch the execution result to an array
$rowItem = mysqli_fetch_array($resultItem);

mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Edit Admin</title>
</head>

<body>
    <h3>Edit Admin</h3>
    <form id="postForm" method="post" action="doAdminEdit.php">
    <input type="hidden" name="loginfirst" value="1">
    <label for="userID">User ID:</label>
    <input type="text" id="userID" name="userID" value="<?php echo $rowItem['user_id']?>" required />
    <br><br>
    <label for="roleID">Role:</label>
    <select name="roleID" id="roleID">
        <?php
            if ($rowItem['role_id'] == 1) {
                echo "<option value='1' selected>Admin</option>";
                echo "<option value='0'>Head Admin</option>";
            } else {
                echo "<option value='1'>Admin</option>";
                echo "<option value='0'selected>Head Admin</option>";
            }
        ?>
    </select>
    <br><br>
    <label for="userName">Username:</label>
    <input type="text" id="userName" name="userName" value="<?php echo $rowItem['username']?>" required />
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="Password" placeholder="'Password' is default" required />
    <br><br>
    <input type="submit" value="Create" />
    </form>
</body>

</html>