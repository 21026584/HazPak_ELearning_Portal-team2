<?php
// Start the session
session_start();

// Retrieve form data
$newPassA = $_POST['passwordA'];
$newPassB = $_POST['passwordB'];
//opens up database for website to access
include("dbFunctions.php");
include("checkSession.php");
// Check if post from changePassword page else bring back to changePassword page
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //checks if passwords are the exact same else brink back to changePassword page

    
    if ($newPassA == $newPassB) {
        $entered_id = $_SESSION['user_id'];
        
        // set the PDO error mode to exception
        $query = "UPDATE users SET password=SHA1('$newPassA'), firstLogin='0'  WHERE user_id='$entered_id'";
        $_SESSION['firstLogin']=0;
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        if ($result === TRUE){
            mysqli_close($link);
            header("Location: index.php");
            exit;
        } else {
            echo "There was an error during the SQL phase to change password";
        }
        
    } else {
        echo "The entered password are not similar";
    }
} else {
    // header("Location: changePassword.php");
    // exit;
    echo "There is an error with the post form inputs";
    header("Location: changePassword.php");
    exit();
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
    echo $_SESSION['user_id'];
    echo $_SESSION['role_id'];
    echo $_SESSION['username'];
    echo $_SESSION['firstLogin'];
    ?>
</body>

</html>