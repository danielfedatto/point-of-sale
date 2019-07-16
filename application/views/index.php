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
					<a class="btnType2" href="<?php echo url::base(); ?>">Saiba mais</a>
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
			foreach($artigos as $art){ 
				$imgArt = glob('admin/upload/artigos/'.$art->ART_ID.'.*');
				if($imgArt){ ?>
					<article>
						<figure>
							<img src="<?php echo url::base().$imgArt[0]; ?>" alt="<?php echo $art->ART_TITULO; ?>">
						</figure>
						<a href="<?php echo url::base(); ?>artigos/ler/<?php echo $art->ART_ID; ?>/<?php echo Controller_Index::arrumaURL(urlencode($art->ART_TITULO)); ?>" title="<?php echo $art->ART_TITULO; ?>">
							<h5><?php echo $art->ART_TITULO; ?></h5>
						</a>
						<a href="<?php echo url::base(); ?>artigos/ler/<?php echo $art->ART_ID; ?>/<?php echo Controller_Index::arrumaURL(urlencode($art->ART_TITULO)); ?>" title="<?php echo $art->ART_TITULO; ?>">
							<p><?php echo Controller_Index::limitar_palavras($art->ART_TEXTO, 10); ?></p>
						</a>
						<div class="articleFooter">
							<span><?php echo Controller_Index::MMMddaaaa($art->ART_DATA); ?></span>
							<!-- <span class="comments">25
								<svg class="icon icon-comments">
									<use xlink:href="#icon-comments"></use>
								</svg>
							</span> -->
						</div>
					</article>
				<?php 
				}
			} ?>
		</div>
	</div>
</section>