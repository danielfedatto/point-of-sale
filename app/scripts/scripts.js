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

// GOOGLE MAPS

function initMap(){
	var mapa;
	var ponto = new google.maps.LatLng(-28.250643, -52.418519);
	var centro = ponto;
	var estilo = [
	];
	var opcoes = {
		 zoom: 18,
		 center: centro,
		 mapTypeId: google.maps.MapTypeId.ROADMAP,
		 panControl: false,
		 zoomControl: true,
		 scrollwheel: false,
		 mapTypeControl: true,
		 scaleControl: false,
		 streetViewControl: false,
		 overviewMapControl: false,
		 zoomControlOptions: {style: google.maps.ZoomControlStyle.SMALL},
		 styles: estilo
	};
	mapa = new google.maps.Map(document.getElementById('map'), opcoes);
	var image = 
		new google.maps.MarkerImage('img/pin.svg',
		new google.maps.Size(200, 200), 	//tamanho total
		new google.maps.Point(0, 0), 	//origem (se for sprite, é diferente de zero)
		new google.maps.Point(19, 25) 	//posição da "ponta" do alfinete
	);
	var marker = new google.maps.Marker({
		position: ponto,
		map: mapa,
		icon: image,
		url: 'https://www.google.com.br/maps/place/Cemit%C3%A9rio+e+Crematorio+Memorial+Vera+Cruz/@-28.251107,-52.418431,17.5z/data=!4m5!3m4!1s0x94e2c09119b0b13f:0x20886aa5ffa1b4ae!8m2!3d-28.2508403!4d-52.4184959'
	});
	google.maps.event.addListener(marker, 'click', function() {
		window.open(marker.url);
	});
}
if (document.getElementsByClassName('local')) {
	$.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyBk62EwVHfJkhiSXfadeNaFhYZhXlZI7bs&sensor=false').done(
		function() {
			initMap();
		});
}