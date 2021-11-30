<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

$detailsMessage = "";
$passwordMessage = "";

if (isset($_POST["saveDetails"])) {
    $account = new Account($con);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if ($account->updateDetails($email, $userLoggedIn)) {
        // Success
        // echo "Success";
        $detailsMessage = "<div class='alertSuccess'>
                                Details updated successfully!
                            </div>";
    } else {
        // Failure
        // echo "Failure";     

        $errorMessage = $account->getUpdateError();
        $detailsMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}


if (isset($_POST["savePasswordButton"])) {
    $account = new Account($con);
    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        $passwordMessage = "<div class='alertSuccess'>
                                Password updated successfully!
                            </div>";
    } else {
        $errorMessage = $account->getUpdateError();

        $passwordMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";
    }
}

?>

<div class="row">
    <div class="col-lg-6">
        <div class="settingsContainer column">
            <div class="formSection">
                <form action="" method="post">
                    <h2>User details</h2>
                    <?php
                    $user = new User($con, $userLoggedIn);
                    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
                    $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
                    $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
                    $username = isset($_POST["username"]) ? $_POST["username"] : $user->getUsername();
                    // echo $firstName . " " . $lastName . " " . $email;

                    ?>
                    <input type="text" name="firstName" placeholder="First Name" class="form-control"
                        value="<?php echo $firstName; ?>" disabled>
                    <input type="text" name="lastName" placeholder="Last Name" class="form-control"
                        value="<?php echo $lastName; ?>" disabled>
                    <input type="text" name="username" placeholder="Username" class="form-control"
                        value="<?php echo $username; ?>" disabled>
                    <input type="email" name="email" class="form-control" id="exampleFormControlInput1"
                        placeholder="name@example.com" value="<?php echo $email; ?>">

                    <div class="message">
                        <?php echo $detailsMessage; ?>
                    </div>

                    <button type="submit" class="btn btn-outline-danger" name="saveDetails">Save</button>
                </form>
            </div>

            <hr>

            <div class="formSection">
                <form action="" method="post">
                    <h2>Update Password</h2>
                    <input type="password" name="oldPassword" id="inputPassword5" class="form-control"
                        placeholder="Old Password">
                    <input type="password" name="newPassword" id="inputPassword5" class="form-control"
                        placeholder="New Password">
                    <input type="password" name="newPassword2" id="inputPassword5" class="form-control"
                        placeholder="Confirm Password">

                    <div class="message">
                        <?php echo $passwordMessage; ?>
                    </div>

                    <button type="submit" name="savePasswordButton" class="btn btn-outline-danger">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <img src="assets\images\home.JPG" alt="home-img" class="title-image">
    </div>
</div>