<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css">
    <title>Add Trainee</title>
</head>

<body>
    <?php
    include "navbar.php"
    ?>
    <h3>Add trainee</h3>

    <form id="postForm" method="post" action="doAddTrainee.php">
        <label for="idUsername">Username:</label>
        <input type="text" id="idUsername" name="username" required />
        <br>
        <label for="traineeID">Trainee ID:</label>
        <br>
        <textarea id="traineeID" name="traineeID" rows="5" cols="30" required></textarea>
        <br>
        <p><label for="intake">Intake:</label></p>
        <textarea id="intake" name="intake" rows="4" cols="50" required></textarea>
        <br>
        <input type="submit" value="Add" />
    </form>
</body>

</html>