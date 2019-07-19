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