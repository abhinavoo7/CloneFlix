function volumeToggle(button) {
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    $(button).find("i").toggleClass("fa-volume-mute");
    $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded() {
    var x = document.getElementsByClassName("previewImage");
    x[0].removeAttribute("hidden");
    document.getElementById("hideButton").hidden = true;
    $('.previewVideo').toggle();
}

function goBack() {
    window.history.back();
}

function startHideTimer() {
    var timeout = null;

    $(document).on("mousemove", function() {
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        timeout = setTimeout(function() {
            $(".watchNav").fadeOut();
        }, 2000);
    })
}

function initVideo(videoId, userLoggedIn) {
    startHideTimer();
    console.log(videoId);
    console.log(userLoggedIn);
    updateProgressTimer(videoId, userLoggedIn);
}

function updateProgressTimer(videoId, username) {
    addDuration(videoId, username);
    var timer;
    $("video").on("playing", function(event) {
            window.clearInterval(timer);
            timer = window.setInterval(function() {
                updateProgress(videoId, username, event.target.currentTime);
            }, 1500);
        })
        .on("ended", function() {
            window.clearInterval(timer);
        })
}

function addDuration(videoId, username) {
    // AJAX request using JQuery
    $.post("ajax/addDuration.php", { videoId: videoId, username: username }, function(data) {
        if (data !== null && data !== "") {
            alert(data);
        }
    });
}

function updateProgress(videoId, username, progress) {
    // AJAX request using JQuery
    $.post("ajax/updateDuration.php", { videoId: videoId, username: username, progress: progress }, function(data) {
        if (data !== null && data !== "") {
            alert(data);
        }
    });
}