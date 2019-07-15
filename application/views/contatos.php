<section class="hero-wrap" style="background-image: url(<?php echo url::base(); ?>dist/img/background_interna.jpg);">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters text align-items-end justify-content-center" data-scrollax-parent="true">
			<div class="col-md-8 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="<?php echo url::base(); ?>">Home</a></span> <span>Contato</span></p>
				<h1 class="mb-5 bread">Contato</h1>
			</div>
		</div>
	</div>
</section>
	<!-- END slider -->

<section class="ftco-section contact-section">
	<div class="container mt-5">
		<div class="row d-flex mb-5 contact-info">
			<div class="col-md-12 mb-4">
				<h2 class="h4">Entre em contato</h2>
			</div>
			<div class="w-100"></div>
			<div class="col-md-12">
				<p><span>Entereço:</span> R. Uruguai, 991 - Vila Nicolau Vergueiro, Passo Fundo - RS, 99010-110</p>
			</div>
			<div class="col-md-6">
				<p><span>Telefones:</span> <a href="tel://54999366657">(54) 99936-6657</a> | <a href="tel://54999219922">(54) 99921-9922</a></p>
			</div>
			<div class="col-md-6">
				<p><span>E-mail:</span> <a href="mailto:contato@costaframe.com">contato@costaframe.com</a></p>
			</div>
		</div>
		<div class="row block-9">
			<div class="col-md-6 pr-md-5">
				<form action="#" id="formContato" action="#" method="post">
				<div class="form-group">
					<label for="CON_NOME" style="display: none;">Seu Nome</label>
					<input type="text" class="form-control" placeholder="Seu Nome" id="CON_NOME" name="CON_NOME" validar="texto">
				</div>
				<div class="form-group">
					<label for="CON_EMAIL" style="display: none;">Seu E-mail</label>
					<input type="text" class="form-control" placeholder="Seu E-mail" id="CON_EMAIL" name="CON_EMAIL" validar="email">
				</div>
				<div class="form-group">
					<label for="CON_FONE" style="display: none;">Seu Telefone</label>
					<input type="text" class="fone form-control" placeholder="Seu Telefone" id="CON_FONE" name="CON_FONE" validar="texto" onblur="verificaTelefone(this);">
				</div>
				<div class="form-group">
					<label for="CON_MENSAGEM" style="display: none;">Sua Mensagem</label>
					<textarea cols="30" rows="7" class="form-control" placeholder="Sua Mensagem" id="CON_MENSAGEM" name="CON_MENSAGEM" validar="texto"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" id="salvarContato" value="Enviar Mensagem" class="btn btn-primary py-3 px-5">
				</div>
				<div id="enviando" style="display: none;"><h2>Aguarde! Enviando mensagem...</h2></div>
				</form>
			
			</div>
			<div class="col-md-6" id="map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3514.332495429712!2d-52.40967198531187!3d-28.257933182567115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94e2c15bdf3b9183%3A0xd66d57372a7c11ef!2sCosta+Frame+-+Arquitetura+e+Engenharia!5e0!3m2!1spt-BR!2sbr!4v1562435138928!5m2!1spt-BR!2sbr" width="570" height="462" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>