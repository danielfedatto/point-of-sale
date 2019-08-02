$(document).ready(function(){
    $(".slider").slick({
        infinite: false,
        dots: true,
        arrows: false,
    });
    $("#teamwork").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 3,
      prevArrow: '<button type="button" class="slick-prev"></button>',
      nextArrow: '<button type="button" class="slick-next"></button>',
      responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
      ]
    });
    $("#clientes").slick({
        infinite: false,
        dots: false,
        arrows: true,
        slidesToShow: 5,
        prevArrow: '<button type="button" class="slick-prev"></button>',
        nextArrow: '<button type="button" class="slick-next"></button>',
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
        ]
    });
});

// MENU MOBILE

var burgerBtn = document.getElementById('burgerBtn');
var body = document.body
burgerBtn.addEventListener('click', function() {
    mobile.classList.toggle('navigation');
    body.classList.toggle('overflow');
}, false);
function testAnim(x) {
    $('.download.meterial-icons').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
};
document.addEventListener(
    'DOMContentLoaded',
    () => {
        const scroller = new SweetScroll({
        /* some options */
        });
    },
    false,
);