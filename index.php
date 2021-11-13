<?php

    require ("includes\config.php");
    require ("includes\classes\PreviewProvider.php");
    require ("includes\classes\Entity.php");

    $userLoggedIn = $_SESSION["userLoggedIn"];

    if(!isset($userLoggedIn)){
        header("Location: login.php");
    }

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createVideoPreview(null);

?>