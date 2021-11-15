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