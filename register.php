<?php

require("includes\classes\FormSanitizer.php");
require("includes\config.php");
require("includes\classes\Account.php");
require("includes\classes\Constants.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {

    $firstName = FormSanitizer::class::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::class::sanitizeFormString($_POST["lastName"]);
    $username = FormSanitizer::class::sanitizeFormUsername($_POST["username"]);
    $email = FormSanitizer::class::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::class::sanitizeFormEmail($_POST["email2"]);
    $password = FormSanitizer::class::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::class::sanitizeFormPassword($_POST["password2"]);
    // echo $firstName." ".$lastName." ".$username." ".$email." ".$email2." ".$password." ".$password2;

    $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

    if ($success) {
        // Store session
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
                <h3>Sign Up</h3>
                <span>to continue to CloneFlix</span>
            </div>

            <form method="POST">

                <?php echo $account->getError(Constants::$firstNameCharacters); ?>

                <input type="text" name="firstName" placeholder="First name" required>


                <?php echo $account->getError(Constants::$lastNameCharacters); ?>

                <input type="text" name="lastName" placeholder="Last name" required>


                <?php echo $account->getError(Constants::$userNameCharacters); ?>
                <?php echo $account->getError(Constants::$userNameTaken); ?>

                <input type="text" name="username" placeholder="Username" required>


                <?php echo $account->getError(Constants::$emailUsed); ?>
                <?php echo $account->getError(Constants::$emailsDiffer); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>

                <input type="email" name="email" placeholder="Email" required>

                <input type="email" name="email2" placeholder="Confirm email" required>


                <?php echo $account->getError(Constants::$passwordsDiffer); ?>
                <?php echo $account->getError(Constants::$passwordLength); ?>

                <input type="password" name="password" placeholder="Password" required>

                <input type="password" name="password2" placeholder="Confirm password" required>

                <input class="btn btn-danger" type="submit" name="submitButton" value="Sign Up">

            </form>

            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>

        </div>

    </div>
</body>

</html>