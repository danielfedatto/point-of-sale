<section class="nosFazemos">
	<div class="containerFluid">
	<h3>A GENTE FAZ:</h3>
	<p><span>Somos especialistas em Varejo.</span></p>
	<div class="content">
		<?php
		foreach($servicos as $ser){ 
			$imgServico = glob('admin/upload/servicos/'.$ser->SER_ID.'.*');
			if($imgServico){ ?>
				<figure><img src="<?php echo url::base().$imgServico[0]; ?>" alt="<?php echo $ser->SER_TITULO; ?>"></figure>
			<?php
			}
		} ?>
	</div>
	</div>
</section>
<section class="indexCases">
	<?php 
	foreach($cases as $cas){ 
		$imgCas = glob('admin/upload/cases/'.$cas->CAS_ID.'.*');
		if($imgCas){ ?>
			<figure>
				<img src="<?php echo url::base().$imgCas[0]; ?>" alt="">
				<figcaption>
					<h3><?php echo $cas->CAS_TITULO; ?></h3>
					<span><?php echo $cas->CAS_TEXTO; ?></span>
					<a class="btnType2" href="<?php echo url::base(); ?>cases">Saiba mais</a>
				</figcaption>
			</figure>
		<?php 
		}
	} ?>
</section>
<section class="indexCustomers">
	<div class="container">
		<div id="clientes">
			<?php 
			foreach($clientes as $cli){ 
				$imgCli = glob('admin/upload/clientes/'.$cli->CLI_ID.'.*');
				if($imgCli){ 
					$onclick = '';
					if($cli->CLI_LINK != ''){
						$onclick = 'onclick="window.open(\''.$cli->CLI_LINK.'\');"';
					} ?>
					<figure>
						<img src="<?php echo url::base().$imgCli[0]; ?>" alt="<?php echo $cli->CLI_TITULO; ?>" <?php echo $onclick; ?>>
					</figure>
				<?php 
				}
			} ?>
		</div>
	</div>
</section>
<section class="indexArticles">
	<h3>AGENTE <span>FALA:</span></h3>
	<div class="container">
		<div class="articleWrap">
			<?php 
			foreach($blog as $blo){ 
				$imgBlo = glob('admin/upload/blog/'.$blo->BLO_ID.'.*');
				if($imgBlo){ 
					$blogcategorias = ORM::factory('blogcategorias')->where('BLO_ID', '=', $blo->BLO_ID)->find_all();
					?>
					<article>
						<figure>
							<img src="<?php echo url::base().$imgBlo[0]; ?>" alt="<?php echo $blo->BLO_TITULO; ?>">
						</figure>
						<div class="categories">
							<?php foreach($blogcategorias as $blc){ ?>
								<a class="btnType2" href="<?php echo url::base(); ?>blog/categoria/<?php echo $blc->categorias->CAT_ID; ?>/<?php echo urlencode($blc->categorias->CAT_TITULO); ?>" title="<?php echo $blc->categorias->CAT_TITULO; ?>"><?php echo $blc->categorias->CAT_TITULO; ?></a>
							<?php } ?>
						</div>
						<a href="<?php echo url::base(); ?>artigos/ver/<?php echo $blo->BLO_ID; ?>/<?php echo Controller_Index::arrumaURL(urlencode($blo->BLO_TITULO)); ?>" title="<?php echo $blo->BLO_TITULO; ?>">
							<h5><?php echo $blo->BLO_TITULO; ?></h5>
						</a>
						<a href="<?php echo url::base(); ?>artigos/ver/<?php echo $blo->BLO_ID; ?>/<?php echo Controller_Index::arrumaURL(urlencode($blo->BLO_TITULO)); ?>" title="<?php echo $blo->BLO_TITULO; ?>">
							<p><?php echo Controller_Index::limitar_palavras($blo->BLO_TEXTO, 10); ?></p>
						</a>
						<div class="articleFooter">
							<span>Por 
								<a href="#"><?php echo $blo->usuarios->USU_NOME; ?></a>
							</span>
							<span><?php echo Controller_Index::tempoCorrido($blo->BLO_DATA_E_HORA); ?></span>
						</div>
					</article>
				<?php 
				}
			} ?>
		</div>
	</div>
</section>