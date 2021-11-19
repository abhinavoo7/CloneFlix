<?php

    require ("includes\header.php");

    if (!isset($_GET["id"])) {
        ErrorMessage::show("No ID passed into page");
    }

    $entityId = $_GET["id"];

    $video = new Video($con, $entityId);
    $video->incrementViews();

?>