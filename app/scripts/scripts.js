$(document).ready(function(){
    $(".sticker").sticky({
      zIndex: 2
    });
    $(".slider").slick({
        infinite: false,
        dots: true,
        arrows: false,
    });
    $(".nosFazemosSlider").slick({
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
    $("#teamwork").slick({
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
    $('#burgerBtn').click(function(){
      $('#mobile').toggleClass('navigation');
      $('body').toggleClass('overflow');
    });
});
$(window).scroll(function() {
	if ($(window).scrollTop() > 10) {
		$('#desk-nav').addClass('sticky');
	} else {
		$('#desk-nav').removeClass('sticky');
	}
});

document.addEventListener(
    'DOMContentLoaded',
    () => {
        const scroller = new SweetScroll({
        /* some options */
        });
    },
    false,
);