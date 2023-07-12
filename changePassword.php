<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <title>Update Password</title>
</head>

<body>

    <div>
        <div>
            <h1>Update Password</h1>

            <form action="updatingPassword.php" method="POST" class="Forms">
                <div class="input-container">
                    <input placeholder="Enter new Password" class="input-field" type="password" id="passwordA" name="passwordA" required>
                    <label for="passwordA" class="input-label">Password</label>
                    <span class="input-highlight"></span>
                </div>

                <div class="input-container">
                    <input placeholder="Reconfirm new password" class="input-field" type="password" id="passwordB" name="passwordB" required>
                    <span class="input-highlight"></span>
                </div>
                <input type="submit" value="Submit" class="submit-button">
            </form>
        </div>
    </div>
</body>

</html>