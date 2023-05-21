<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body class="d-flex justify-content-center RootLoginBackground">
    <div class="d-flex justify-content-center RootLoginForm">
        <div class="Block">
            <h1 class="TitleText">Sign In</h1>

            <form action="authentication.php" method="POST" class="Forms">
                <label for="username">Username:</label>
                <br></br>
                <input type="text" id="username" name="username" required placeholder="Enter Username"><br>
   
                <label for="password">Password:</label>
                <br></br>
                <input type="password" id="password" name="password" required placeholder="Enter Password"><br>
                <br></br>
                <input type="submit" value="Login">
                <!-- test -->
            </form>
        </div>
    </div>
</body>

</html>
