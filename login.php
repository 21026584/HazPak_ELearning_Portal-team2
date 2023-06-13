<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
    <img src='Images/HazPakLogo.png' class="logo"> </img>
</head>
<style>
.logo{
    width:10%;
    height:10%;
    margin-left: 100px
}
</style>

<body class="d-flex justify-content-center RootBackground">

    <div class="d-flex justify-content-center RootLoginForm">
        <div class="Block">
            <h1 class="TitleText">Sign In</h1>

            <form action="authentication.php" method="POST" class="Forms">
                <div class="input-container">
                    <input placeholder="Enter username" class="input-field" type="text" id="username" name="username" required>
                    <label for="username" class="input-label">Username</label>
                    <span class="input-highlight"></span>
                </div>

                <div class="input-container">
                    <input placeholder="Enter password" class="input-field" type="password" id="password" name="password" required>
                    <label for="password" class="input-label">Password</label>
                    <span class="input-highlight"></span>
                </div>
                <input type="submit" value="Sign In" class="submit-button">
            </form>
        </div>
    </div>
</body>

</html>