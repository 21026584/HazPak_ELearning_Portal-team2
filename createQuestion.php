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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <title>Create Question</title>    
    </head>   
    <body>

        <h1>Create Question</h1>

        <form id="postForm" method="post" class="questionForm" action="doCreateQuestion.php">
            Question Type:
            <select name="questionType" name="quType" id="quType" class="question-type">
                <option value="" selected="selected">Select Question Type</option>
                <?php
                    for ($i = 0; $i < count($arrItems); $i++) {
                        $name = $arrItems[$i]['type_name'];
                        $idType = $arrItems[$i]['type_id'];
                ?>
                <option value="<?php echo $idType?>"><?php echo $name?></option>
                <?php }; ?>
            </select>
            <br><br>
            <div id="questionDetails" class="question-root-details">
                <h6>Select question type before continuing</h6>
            </div>
            <input type="submit" value="Submit">  
        </form>

        

        <script>
            function redirectToPage(url) {
                window.location.href = url;
            }

            $(document).ready(function() {
                $('#quType').change(function() {
                    var questionId = $(this).val();
                    // Send an AJAX request to a PHP script that changes the form's question details
                    $.ajax({
                        url: 'getQuestionDetails.php',
                        type: 'POST',
                        data: {
                            questionId: questionId
                        },
                        success: function(response) {
                            // Update the content of the questionDetails container with the response
                            $('#questionDetails').html(response);
                        },

                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
            });
        </script>

        <script>
            var moreIds = 0;
            $("#add-input").click(function () {
                moreIds = moreIds + 1;
                $("#input-container").append('<input type="text" id="'moreIds'" class="ansOptions" name="options"/><button class="remove-input">-</button><br>');
            });
            $(".remove-input").click(function () {//this removes the entire form entirely
                $(this).parent().remove();
            });
        </script>
    </body>
</html>