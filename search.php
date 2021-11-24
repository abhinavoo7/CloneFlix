<?php

require_once("includes\header.php");

?>

<div class="textboxContainer">
    <form class="d-flex">
        <input id="search" class="form-control me-2 searchInput" type="search"
            placeholder="Search for movies or tv shows" aria-label="Search">
    </form>
</div>

<div class="results">

</div>

<script>
$(function() {
    var username = '<?php echo $userLoggedIn ?>';
    var timer;
    $(".searchInput").keyup(function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            var val = $(".searchInput").val();
            if (val != "") {
                $.post("ajax/getSearchResults.php", {
                    term: val,
                    username: username
                }, function(data) {
                    $(".results").html(data);
                })
            } else {
                $(".results").html("");
            }
        }, 500);
    })
})
</script>