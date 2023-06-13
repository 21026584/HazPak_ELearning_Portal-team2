<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style.css">
    <title>Create Assessment</title>
</head>

<body>
    <?php
    include "navbar.php"
    ?>
    <h3>Create Assessment</h3>

    <form id="postForm" method="post" action="doCreateAssessment.php">
        <label for="idName">Assessment Name:</label>
        <input type="text" id="idName" name="name" required />
        <label for="idInstuc">Instructions:</label>
        <textarea id="idInstuc" name="instruction" rows="5" cols="30" required></textarea>
        <label for="idTime">Enter in release Time:</label>
        <input type="datetime-local" id="idTime" name="time" required />
        <p><label for="idQuestion">Questions:</label></p>
        <textarea id="idQuestion" name="question" rows="4" cols="50" required></textarea>
        <input type="submit" value="Create" />
    </form>
</body>

</html>