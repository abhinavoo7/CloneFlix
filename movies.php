<?php

    require("includes\header.php");

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createMoviesPreviewVideo(null);

    $containers = new CategoryContainers($con, $userLoggedIn);
    echo $containers->showMovieCategories();