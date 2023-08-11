<?php
    // php file that contains the common database connection code
    include "dbFunctions.php";
    // Check user session
    include("checkSession.php");
    // Navbar
    include "navbar.php";

    // && !empty($_POST['instruction']) && !empty($_POST['time']) && isset($_POST['inputQuestion'])&& !empty($_POST['idCourse'])
    if (!empty($_POST['userID'])){
        if(!empty($_POST['roleID'])){
            if(!empty($_POST['userName'])){
                if(!empty($_POST['password'])){
                    try {
                        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
            
                    try {
                        // Assume $foreign_key_value is the foreign key value you want to use
                        $foreign_key_value = $_POST['roleID'];
                    
                        // Prepare the SQL statement
                        $stmt = $conn->prepare("UPDATE users SET user_id = :value0, role_id = :foreign_key, username = :value1, password = :value2, firstLogin = :value3 WHERE user_id = :previous_id");
                    
                        // Bind parameters
                        //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new admin into the user database
                        $id = $_POST['userID'];
                        $username = $_POST['userName'];
                        $password = SHA1($_POST['password']);
                        $first = $_POST['loginfirst'];
                        $locate = $_POST['previousID'];
                        $stmt->bindParam(':value0', $id);
                        $stmt->bindParam(':value1', $username);
                        $stmt->bindParam(':value2', $password);
                        $stmt->bindParam(':value3', $first);
                        $stmt->bindParam(':previous_id', $locate);
                        $stmt->bindParam(':foreign_key', $foreign_key_value);
                    
                        // Execute the query
                        $stmt->execute();
                    
                        echo "Admin updated successfully!";
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } else {
                    echo "Password is missing";
                }
            } else {
                echo "Username is missing";
            }
        } else {
            echo "Role ID is missing";
        }
    } else {
        echo "User ID is missing";
    }
    // Closes the Database conection 
    mysqli_close($link);
?>
<!DOCTYPE HTML>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Edit Admins</title>
    </head>

    <body>
        <p><a href="admin.php" class="custom-nav-link">Return</a> to Admin table</p>
    </body>

</html>