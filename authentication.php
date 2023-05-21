<?php
// Start the session
session_start();

// Retrieve form data
$enteredUsername = $_POST['username'];
$enteredPassword = $_POST['password'];

// Check if post
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username'])) {
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];

        // Include database connectuin
        include("dbFunctions.php");

        // Query 
        $query = "SELECT user_id, role_id, username FROM users 
              WHERE username='$entered_username' AND 
              password = '$entered_password'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        // Fetching user info from database
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role_id'];
            $_SESSION['username'] = $row['username'];

            $msg = "<h3>Succesful login</h3>";
        } else {
            $msg = "<h3>Sorry, you must enter a valid username 
                and password to log in.</h3>";
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>authentication</title>
</head>

<body>
    <?php
    echo $msg;
    echo $_SESSION['user_id'];
    echo $_SESSION['role'];
    echo $_SESSION['username'];
    ?>
</body>

</html>