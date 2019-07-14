$(document).ready(function(){
    $(".slider").slick({
        infinite: false,
        dots: true,
        arrows: false,
    });
    $("#clientes").slick({
        infinite: false,
        dots: false,
        arrows: true,
    });
});