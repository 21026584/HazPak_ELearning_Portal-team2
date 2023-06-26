<?php
    session_start();
    // php file that contains the common database connection code
    include "dbFunctions.php";

    $typeQuestion = "SELECT * From question_type";

    $resultItems = mysqli_query($link, $typeQuestion) or die(mysqli_error($link));

    while ($row = mysqli_fetch_assoc($resultItems)) {
        $arrItems[] = $row;
    }
    mysqli_close($link);
    // SQL statement will make arraylist and input it into dropdown list for user to chose question type
    // Can be use if the amount of question type is change or the name is updated
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="stylesheets/style.css" rel="stylesheet" type="text/css"/>
        <title>Create Question</title>    
    </head>   
    <body>

        <h1>Create Question</h1>

        <form id="postForm" method="post"  action="doCreateQuestion.php">
            Question Type:
            <select name="quType" id="quType" onchange="myFunction()">
                <option value="" selected="selected">Select subject</option>
                <?php
                    for ($i = 0; $i < count($arrItems); $i++) {
                        $name = $arrItems[$i]['type_name'];
                        $idType = $arrItems[$i]['type_id'];
                ?>
                <option value="<?php echo $idType?>"><?php echo $name?></option>
                <?php }; ?>
            </select>
            <!-- going to require some scripting on the form page since choosing a question type will change how the form will look like -->
            <!-- Make take a while gotta frshen up on some topics -->
            <br><br>
            
            <input type="submit" value="Submit">  
        </form>

        <p id = "checking"></p>

        <script>
        function myFunction() {
            var x = document.getElementById("quType").value;
            <?php
            $selectedType = $_GET['x'];
            ?>
            document.getElementById("checking").innerHTML = "You selected: " + x;
        }
        </script>
    </body>
</html>