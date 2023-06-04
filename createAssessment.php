<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Create Assessments</title>
</head>

<body>
    <?php include "navbar.php" ?>
    <h3>Create Assessments</h3>

    <form id="postForm" method="post" action="doCreateAssessment.php">
        <label for="idName">Assessment Name:</label>
        <input type="text" id="idName" name="name" required />
        <label for="idInstuc">Instructions:</label>
        <textarea id="idInstuc" name="instruction" rows="5" cols="30" required></textarea>
        <label for="idTime">Enter in release Time:</label>
        <input type="datetime-local" id="idTime" name="time" required />
        <p><label for="idQuestion">Questions:</label></p>
        <textarea id="idQuestion" name="question" rows="4" cols="50" required></textarea>
    </form>
</body>

</html>