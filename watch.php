<?php

require("includes\header.php");

if (!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}

$entityId = $_GET["id"];

$video = new Video($con, $entityId);
$video->incrementViews();
?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>
    <video controls autoplay>
        <source src="<?php echo $video->getFilePath(); ?>" type="video/mp4">
    </video>
</div>