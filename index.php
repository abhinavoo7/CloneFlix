<?php

    require ("includes\header.php");

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createVideoPreview(null);

?>