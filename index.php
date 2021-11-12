<?php

    require ("includes\config.php");

    if(!isset($_SESSION["userLoggedIn"])){
        header("Location: login.php");
    }

?>