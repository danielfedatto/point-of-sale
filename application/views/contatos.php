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
					<div class="inputControll">
						<input id="nome" type="text" name="nome" value="" placeholder="Nome:">
					</div>
					<div class="inputControll formGroup">
						<input id="telefone" type="text" name="nome" value="" placeholder="Fone:">
						<input id="email" type="mail" name="email" value="" placeholder="E-mail:">
					</div>
					<div class="inputControll">
						<textarea id="mensagem" name="" cols="30" rows="10" placeholder="Mensagem:"></textarea>
						<button class="btnType2" type="submit">Enviar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="local">
	<div id="map"></div>
</section>