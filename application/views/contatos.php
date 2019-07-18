<section class="contatoInterno">
	<div class="container">
		<h3>Tá na hora de <span>fazer</span> acontecer!</h3>
		<div class="contatoController">
			<div class="contatoInfo">
				<address>
					<h6><?php echo $titulo; ?></h6>
					<?php echo $endereco; ?>
					<br>
					<?php echo $email; ?>
					<br>
					<span><?php echo $telefone; ?></span>
				</address>
				<div class="horarios">
					<h6>Horários de Atendimento</h6>
					<?php echo $atendimento; ?>
				</div>
			</div>
			<div class="contatoForm">
				<div id="contato-form">
					<form action="#" id="formContato">
						<div class="inputControll">
							<input type="text" id="CON_NOME" name="CON_NOME" label="Nome" validar="texto" value="" placeholder="Nome:">
						</div>
						<div class="inputControll formGroup">
							<input type="text" class="fone" id="CON_FONE" name="CON_FONE" label="Fone" validar="texto" value="" placeholder="Fone:">
							<input type="mail" id="CON_EMAIL" name="CON_EMAIL" label="E-mail" validar="email" value="" placeholder="E-mail:">
						</div>
						<div class="inputControll">
							<textarea id="CON_MENSAGEM" name="CON_MENSAGEM" label="Mensagem" validar="texto" cols="30" rows="10" placeholder="Mensagem:"></textarea>
							<button class="btnType2" id="salvarContato" type="submit">Enviar</button>
						</div>
						<div id="enviando" style="display: none">Enviando...</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="local">
	<div id="map"></div>
</section>
<script>
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
</script>