<?php

    require("includes\classes\FormSanitizer.php");
    require("includes\config.php");
    require("includes\classes\Account.php");
    require("includes\classes\Constants.php");

    $account = new Account($con);

    if (isset($_POST["submitButton"])) {

        $username = FormSanitizer::class::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::class::sanitizeFormPassword($_POST["password"]);
        // echo $firstName." ".$lastName." ".$username." ".$email." ".$email2." ".$password." ".$password2;

        $success = $account->login($username,$password);

        if ($success) {
            // Store session
            $_SESSION["userLoggedIn"] = $username;

            header("Location: index.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CloneFlix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="assets\style\style.css">
</head>

<body>
    <div class="signInContainer">

        <div class="column">

            <div class="header">
                <img src="assets/images/Logo_adobespark.png" title="Logo" alt="Site logo" />
                <h3>Sign In</h3>
                <span>to continue to CloneFlix</span>
            </div>

            <form method="POST">

                <?php echo $account->getError(Constants::$loginFailed); ?>

                <input type="text" name="username" placeholder="Username" required>

                <input type="password" name="password" placeholder="Password" required>

                <input class="btn btn-danger" type="submit" name="submitButton" value="Login">

            </form>

            <a href="register.php" class="signIn    Message">Don't have an account? Sign up here!</a>

        </div>

    </div>
</body>

</html>