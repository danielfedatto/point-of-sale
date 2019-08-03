<section class="nosFazemos">
	<div class="container">
	<h3>A gente faz:</h3>
	<p><span>Somos especialistas em Varejo.</span></p>
	<div class="content">
		<?php
		foreach($servicos as $ser){ 
			$imgServico = glob('admin/upload/servicos/'.$ser->SER_ID.'.*');
			if($imgServico){ ?>
				<figure>
					<a href="<?php echo url::base(); ?>cases/servicos/<?php echo $ser->SER_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($ser->SER_TITULO)); ?>">
						<img src="<?php echo url::base().$imgServico[0]; ?>" alt="<?php echo $ser->SER_TITULO; ?>">
					</a>
				</figure>
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
<section class="indexBlog">
	<div class="container">
		<h3> A gente<span> fala:</span></h3>
		<div class="blogWrap">
			<?php 
			foreach($blog as $blo){ 
				$imgBlo = glob('admin/upload/blog/'.$blo->BLO_ID.'.*');
				if($imgBlo){ 
					$blogcategorias = ORM::factory('blogcategorias')->where('BLO_ID', '=', $blo->BLO_ID)->find_all(); ?>
					<article onclick="location.href='<?php echo url::base(); ?>post/ver/<?php echo $blo->BLO_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($blo->BLO_TITULO)); ?>'">
						<figure>
							<img src="<?php echo url::base().$imgBlo[0]; ?>" alt="<?php echo $blo->BLO_TITULO; ?>">
							<figcaption>
								<div class="categories">
									<?php foreach($blogcategorias as $blc){ ?>
										<a class="btnType2" href="<?php echo url::base(); ?>blog/categoria/<?php echo $blc->categorias->CAT_ID; ?>/<?php echo urlencode($blc->categorias->CAT_TITULO); ?>" title="<?php echo $blc->categorias->CAT_TITULO; ?>"><?php echo $blc->categorias->CAT_TITULO; ?></a>
									<?php } ?>
								</div>
								<div class="articleFooter">
									<a href="<?php echo url::base(); ?>post/ver/<?php echo $blo->BLO_ID; ?>/<?php echo urlencode(Controller_Index::arrumaURL($blo->BLO_TITULO)); ?>" title="<?php echo $blo->BLO_TITULO; ?>">
										<h5><?php echo $blo->BLO_TITULO; ?></h5>
									</a>
									<span>Por <a href="<?php echo url::base(); ?>blog/autor/<?php echo $blo->usuarios->USU_ID; ?>"><?php echo $blo->usuarios->USU_NOME; ?></a></span>
									<span class="comments"><?php echo Controller_Index::tempoCorrido($blo->BLO_DATA_E_HORA); ?>
										<i class="left">
											<svg class="icon icon-access_time left">
												<use xlink:href="#icon-access_time"></use>
											</svg>
										</i>
									</span>
								</div>
							</figcaption>
						</figure>
					</article>
				<?php 
				}
			} ?>
		</div>
	</div>
</section>