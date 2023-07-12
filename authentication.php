<?php
// Start the session
session_start();

// Retrieve form data
$enteredUsername = $_POST['username'];
$enteredPassword = $_POST['password'];

// Check if post from login page else bring back to login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username'])) {
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];

        // Include database connection
        include("dbFunctions.php");

        // Query 
        $query = "SELECT user_id, role_id, username, firstLogin FROM users 
              WHERE username='$entered_username' AND 
              password = SHA1('$entered_password')";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        // Fetching user info from database
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['firstLogin'] = $row['firstLogin'];

            $msg = "<h3>Succesful login</h3>";
            header("Location: index.php");
            exit;
        } else {
            $msg = "<h3>Sorry, you must enter a valid username
                and password to log in.</h3>";
            header("Location: login.php");
            exit;
        }
    }
} else {
    header("Location: login.php");
    exit;
}

// Close database connection
mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
    <title>authentication</title>
</head>

<body>
    <?php
    echo $msg;
    echo $_SESSION['user_id'];
    echo $_SESSION['role_id'];
    echo $_SESSION['username'];
    echo $_SESSION['firstLogin'];
    ?>
</body>

</html>