<?php

require("includes\config.php");
require("includes\classes\PreviewProvider.php");
require("includes\classes\Entity.php");
require("includes\classes\CategoryContainers.php");
require("includes\classes\EntityProvider.php");
require("includes\classes\ErrorMessage.php");
require("includes\classes\SeasonProvider.php");
require("includes\classes\Season.php");
require("includes\classes\Video.php");

$userLoggedIn = $_SESSION["userLoggedIn"];

if (!isset($userLoggedIn)) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CloneFlix</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- CSS stylesheet -->
    <link rel="stylesheet" href="assets\style\style.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/6fd5bc21ba.js" crossorigin="anonymous"></script>

    <!-- JS -->
    <script src="assets\js\script.js"></script>
</head>

<body>

    <div class="wrapper">


        <?php
            if(!isset($hideNav)){
                include_once("includes/navBar.php");
            }
        ?>

        <!-- </div> -->



        <!-- </body>

</html> -->