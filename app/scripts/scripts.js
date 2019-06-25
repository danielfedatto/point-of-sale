$(document).ready(function(){
    $("#sticker").sticky({
        topSpacing: 0,
        zIndex: 999,
    });
    $(".slider").slick({
        infinite: false,
        dots: true,
        arrows: false,
    });
});