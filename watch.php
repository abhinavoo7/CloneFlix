<?php

$hideNav = true;

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

    <div class="videoControls upNext">
        <button><i class="fas fa-redo"></i></button>
    </div>

    <video controls autoplay>
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
</div>
<script>
initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>