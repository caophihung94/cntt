//Slider
$(document).ready(function () {
    $('.bxslider').bxSlider({
        captions: true,
        pager: false,
        auto: true,
        autoHover: true,
    });
});

//Auto focus
$('#searchModal').on('shown.bs.modal', function () {
    $('#search_box').focus();
})

