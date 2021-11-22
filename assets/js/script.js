$(document).scroll(function() {
    var isScrolled = $(this).scrollTop() > $(".topBar").height();
    $(".topBar").toggleClass("scrolled", isScrolled);
})

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

function initVideo(videoId, username) {
    startHideTimer();
    setStartTime(videoId, username);
    console.log(videoId);
    console.log(username);
    updateProgressTimer(videoId, username);
}

function updateProgressTimer(videoId, username) {
    addDuration(videoId, username);
    var timer;
    $("video").on("playing", function(event) {
            window.clearInterval(timer);
            timer = window.setInterval(function() {
                updateProgress(videoId, username, event.target.currentTime);
            }, 2500);
        })
        .on("ended", function() {
            setFinished(videoId, username);
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

function setFinished(videoId, username) {
    // AJAX request using JQuery
    $.post("ajax/setFinish.php", { videoId: videoId, username: username }, function(data) {
        if (data !== null && data !== "") {
            alert(data);
        }
    });
}

function setStartTime(videoId, username) {
    // AJAX request using JQuery
    $.post("ajax/getProgress.php", { videoId: videoId, username: username }, function(data) {
        if (isNaN(data)) {
            alert(data);
            return;
        }
        $("video").on("canplay", function() {
            this.currentTime = data;
            $("video").off("canplay");
        })
    });
}