<?php
    // php file that contains the common database connection code
    include("dbFunctions.php");
    // Check user session
    include("checkSession.php");





    if (!empty($_POST['courseId']) && (!empty($_POST['description'])) && (!empty($_POST['traineeID']))) {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        try {
            // Assume $foreign_key_value is the foreign key value you want to use
            //  $foreign_key_value = $_POST['traineeID']; 
        
            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO courses(user_id, course_id) VALUES (:value0, :value1);");
        
            // Bind parameters
            //Assign data retreived from form to the following variables below respectively to will input statement into SQL to make add in a new assessment into the assessment database
            $course_id = $_POST['courseId'];
            $description = $_POST['description'];
            $traineeID = $_POST['traineeID'];
            $trainee_JSON = json_encode($traineeID);
            $stmt->bindParam(':value0', $trainee_JSON);
            $stmt->bindParam(':value1', $course_id);
            // $stmt->bindParam(':value2', $description);
        
            // Execute the query
            $stmt->execute();
        
            echo "course inserted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    } else {
            $message = "All trainee details have to be provided.";
    }
    
?>



