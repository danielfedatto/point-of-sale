<section class="home-slider owl-carousel">
	<?php
	foreach($banners as $projeto){ 
		$imgBan = glob('admin/upload/projetos/'.$projeto->PRO_ID.'.*');
		if($imgBan){ ?>
			<a href="#" onclick="$('#banner_<?php echo $projeto->PRO_ID; ?>').click();" class="slider-item page-scroll" style="background-image: url(<?php echo url::base().$imgBan[0]; ?>);">
				<div class="overlay"></div>
				<div class="container">
					<div class="row slider-text align-items-end justify-content-center">
						<div class="col-md-12 ftco-animate p-4" data-scrollax=" properties: { translateY: '70%' }">
							<h1 class="mb-3" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><?php echo $projeto->PRO_NOME; ?></h1>
						</div>
					</div>
				</div>
			</a>
		<?php
		}
	} ?>
</section>
<div style="display: none;">
	<?php
	foreach($banners as $projeto){ 
		$imgBan = glob('admin/upload/projetos/'.$projeto->PRO_ID.'.*');
		if($imgBan){ ?>

			<a id="banner_<?php echo $projeto->PRO_ID; ?>" href="<?php echo url::base().$imgBan[0]; ?>" class="slider-item page-scroll" style="background-image: url(<?php echo url::base().$imgBan[0]; ?>);"
					data-fancybox="banner_<?php echo $projeto->PRO_ID; ?>"                         
					data-caption="<?php echo $projeto->PRO_NOME; ?>">

			<?php
			$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto->PRO_ID."_%")->find_all(); 

			foreach($galeria as $key => $gal){
				$imgGal = glob("admin/".$gal->GAL_IMAGEM);
				if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto->PRO_ID . "_")){ ?>
					<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
						data-fancybox="banner_<?php echo $projeto->PRO_ID; ?>"                         
						data-thumb="<?php echo url::base().$imgGal[0]; ?>"
						data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
					</a>
				<?php 
				} 
			} 
		}
	} ?> 
</div>
<!-- END slider -->

<section class="ftco-counter" id="section-counter">
	<div class="container">
		<div class="row d-flex">
			<div class="col-md-7 py-sm-3 py-md-5">
				<div class="row py-5">
					<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
						<div class="block-18">
							<div class="text">
								<strong class="number" data-number="<?php echo $numeros->NUM_QUANTIDADE_1; ?>">0</strong>
								<span><?php echo $numeros->NUM_OPCAO_1; ?></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
						<div class="block-18">
							<div class="text">
								<strong class="number" data-number="<?php echo $numeros->NUM_QUANTIDADE_2; ?>">0</strong>
								<span><?php echo $numeros->NUM_OPCAO_2; ?></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
						<div class="block-18">
							<div class="text">
								<strong class="number" data-number="<?php echo $numeros->NUM_QUANTIDADE_3; ?>">0</strong>
								<span><?php echo $numeros->NUM_OPCAO_3; ?></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
						<div class="block-18">
							<div class="text">
								<strong class="number" data-number="<?php echo $numeros->NUM_QUANTIDADE_4; ?>">0</strong>
								<span><?php echo $numeros->NUM_OPCAO_4; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$imgNumeros = glob('admin/upload/numeros/'.$numeros->NUM_ID.'.*'); 
			if($imgNumeros){ ?>
				<div class="col-md-5 d-flex justify-content-center align-items-center img exp" style="background-image: url(<?php echo url::base().$imgNumeros[0]; ?>);"></div>
			<?php
			} ?>
		</div>
	</div>
</section>

<section class="ftco-services" id="services">
	<div class="container">
		<div class="row no-gutters">
			<div class="col-md-5 ftco-animate py-5 nav-link-wrap aside-stretch">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<h3 class="ml-3">Serviços</h3>

					<?php 
					$active = 'active';
					$trueFalse = 'true';
					foreach($servicos as $ser){ ?>
						<a class="nav-link px-4 <?php echo $active; ?>" id="v-pills-<?php echo $ser->SER_ID; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $ser->SER_ID; ?>" role="tab" aria-controls="v-pills-<?php echo $ser->SER_ID; ?>" aria-selected="<?php echo $trueFalse; ?>"><span class="mr-3 <?php echo $ser->SER_FLATICON; ?>"></span> <?php echo $ser->SER_NOME; ?></a>
						<?php 
						$active = '';
						$trueFalse = 'false';
					} ?>
				</div>
			</div>
			<div class="col-md-7 ftco-animate p-4 p-md-5 d-flex align-items-center">
			
				<div class="tab-content pl-md-5" id="v-pills-tabContent">

					<?php 
					$active = 'active';
					foreach($servicos as $ser){ ?>
						
						<div class="tab-pane fade show <?php echo $active; ?> py-5" id="v-pills-<?php echo $ser->SER_ID; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $ser->SER_ID; ?>-tab">
							<span class="icon mb-3 d-block <?php echo $ser->SER_FLATICON; ?>"></span>
							<h2 class="mb-4"><?php echo $ser->SER_NOME; ?></h2>
							<?php echo $ser->SER_TEXTO; ?>
						</div>

						<?php 
						$active = '';
					} ?>

				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section" id="projects">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12 heading-section ftco-animate mb-3">
						<h2 class="mb-4">Projetos</h2>
						<!-- <p><a href="<?php echo url::base(); ?>projetos">ver todos</a></p> -->
					</div>
				</div>
				<?php
				$img1 = glob('admin/upload/projetos/'.$projeto1->PRO_ID.'.*'); 
				if($img1){ ?>
					<a href="<?php echo url::base().$img1[0]; ?>" class="portfolio ftco-animate"
						data-fancybox="projeto_<?php echo $projeto1->PRO_ID; ?>"                         
						data-caption="<?php echo $projeto1->PRO_NOME; ?>">

						<div class="d-flex icon justify-content-center align-items-center">
							<span class="ion-md-search"></span>
						</div>
						<div class="d-flex heading align-items-end">
							<h3>
								<span><?php echo $projeto1->servicos->SER_NOME; ?></span><br>
								<?php echo $projeto1->PRO_NOME; ?>
							</h3>
						</div>
						<img src="<?php echo url::base().$img1[0]; ?>" class="img-fluid" alt="<?php echo $projeto1->PRO_NOME; ?>">
					</a>
					<div style="display: none;">
						<?php
						$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto1->PRO_ID."_%")->find_all();
						foreach($galeria as $key => $gal){
							$imgGal = glob("admin/".$gal->GAL_IMAGEM);
							if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto1->PRO_ID . "_")){ ?>
								<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
									data-fancybox="projeto_<?php echo $projeto1->PRO_ID; ?>"                         
									data-thumb="<?php echo url::base().$imgGal[0]; ?>"
									data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
								</a>
							<?php 
							} 
						} ?> 
					</div>
				<?php
				} 
				$img2 = glob('admin/upload/projetos/'.$projeto2->PRO_ID.'.*'); 
				if($img2){ ?>
					<a href="<?php echo url::base().$img2[0]; ?>" class="portfolio ftco-animate"
						data-fancybox="projeto_<?php echo $projeto2->PRO_ID; ?>"                         
						data-caption="<?php echo $projeto2->PRO_NOME; ?>">

						<div class="d-flex icon justify-content-center align-items-center">
							<span class="ion-md-search"></span>
						</div>
						<div class="d-flex heading align-items-end">
							<h3>
								<span><?php echo $projeto2->servicos->SER_NOME; ?></span><br>
								<?php echo $projeto2->PRO_NOME; ?>
							</h3>
						</div>
						<img src="<?php echo url::base().$img2[0]; ?>" class="img-fluid" alt="<?php echo $projeto2->PRO_NOME; ?>">
					</a>
					<div style="display: none;">
						<?php
						$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto2->PRO_ID."_%")->find_all();
						foreach($galeria as $key => $gal){
							$imgGal = glob("admin/".$gal->GAL_IMAGEM);
							if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto2->PRO_ID . "_")){ ?>
								<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
									data-fancybox="projeto_<?php echo $projeto2->PRO_ID; ?>"                         
									data-thumb="<?php echo url::base().$imgGal[0]; ?>"
									data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
								</a>
							<?php 
							} 
						} ?> 
					</div>
				<?php
				} 
				$img3 = glob('admin/upload/projetos/'.$projeto3->PRO_ID.'.*'); 
				if($img3){ ?>
					<a href="<?php echo url::base().$img3[0]; ?>" class="portfolio ftco-animate"
						data-fancybox="projeto_<?php echo $projeto3->PRO_ID; ?>"                         
						data-caption="<?php echo $projeto3->PRO_NOME; ?>">

						<div class="d-flex icon justify-content-center align-items-center">
							<span class="ion-md-search"></span>
						</div>
						<div class="d-flex heading align-items-end">
							<h3>
								<span><?php echo $projeto3->servicos->SER_NOME; ?></span><br>
								<?php echo $projeto3->PRO_NOME; ?>
							</h3>
						</div>
						<img src="<?php echo url::base().$img3[0]; ?>" class="img-fluid" alt="<?php echo $projeto3->PRO_NOME; ?>">
					</a>
					<div style="display: none;">
						<?php
						$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto3->PRO_ID."_%")->find_all();
						foreach($galeria as $key => $gal){
							$imgGal = glob("admin/".$gal->GAL_IMAGEM);
							if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto3->PRO_ID . "_")){ ?>
								<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
									data-fancybox="projeto_<?php echo $projeto3->PRO_ID; ?>"                         
									data-thumb="<?php echo url::base().$imgGal[0]; ?>"
									data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
								</a>
							<?php 
							} 
						} ?> 
					</div>
				<?php
				} ?>
			</div>
			<div class="col-md-8">
				<?php
				$img4 = glob('admin/upload/projetos/'.$projeto4->PRO_ID.'.*'); 
				if($img4){ ?>
					<a href="<?php echo url::base().$img4[0]; ?>" class="portfolio ftco-animate"
						data-fancybox="projeto_<?php echo $projeto4->PRO_ID; ?>"                         
						data-caption="<?php echo $projeto4->PRO_NOME; ?>">

						<div class="d-flex icon justify-content-center align-items-center">
								<span class="ion-md-search"></span>
						</div>
						<div class="d-flex heading align-items-end">
							<h3>
								<span><?php echo $projeto4->servicos->SER_NOME; ?></span><br>
								<?php echo $projeto4->PRO_NOME; ?>
							</h3>
						</div>
						<img src="<?php echo url::base().$img4[0]; ?>" class="img-fluid" alt="<?php echo $projeto4->PRO_NOME; ?>">
					</a>
					<div style="display: none;">
						<?php
						$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto4->PRO_ID."_%")->find_all();
						foreach($galeria as $key => $gal){
							$imgGal = glob("admin/".$gal->GAL_IMAGEM);
							if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto4->PRO_ID . "_")){ ?>
								<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
									data-fancybox="projeto_<?php echo $projeto4->PRO_ID; ?>"                         
									data-thumb="<?php echo url::base().$imgGal[0]; ?>"
									data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
								</a>
							<?php 
							} 
						} ?> 
					</div>
				<?php
				} ?>
				<div class="row">
					<div class="col-md-6">
						<?php
						$img5 = glob('admin/upload/projetos/'.$projeto5->PRO_ID.'.*'); 
						if($img5){ ?>
							<a href="<?php echo url::base().$img5[0]; ?>" class="portfolio ftco-animate"
								data-fancybox="projeto_<?php echo $projeto5->PRO_ID; ?>"                         
								data-caption="<?php echo $projeto5->PRO_NOME; ?>">

								<div class="d-flex icon justify-content-center align-items-center">
									<span class="ion-md-search"></span>
								</div>
								<div class="d-flex heading align-items-end">
									<h3>
										<span><?php echo $projeto5->servicos->SER_NOME; ?></span><br>
										<?php echo $projeto5->PRO_NOME; ?>
									</h3>
								</div>
								<img src="<?php echo url::base().$img5[0]; ?>" class="img-fluid" alt="<?php echo $projeto5->PRO_NOME; ?>">
							</a>
							<div style="display: none;">
								<?php
								$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto5->PRO_ID."_%")->find_all();
								foreach($galeria as $key => $gal){
									$imgGal = glob("admin/".$gal->GAL_IMAGEM);
									if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto5->PRO_ID . "_")){ ?>
										<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
											data-fancybox="projeto_<?php echo $projeto5->PRO_ID; ?>"                         
											data-thumb="<?php echo url::base().$imgGal[0]; ?>"
											data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
										</a>
									<?php 
									} 
								} ?> 
							</div>
						<?php
						} ?>
					</div>
					<div class="col-md-6">
						<?php
						$img6 = glob('admin/upload/projetos/'.$projeto6->PRO_ID.'.*'); 
						if($img6){ ?>
							<a href="<?php echo url::base().$img6[0]; ?>" class="portfolio ftco-animate"
								data-fancybox="projeto_<?php echo $projeto6->PRO_ID; ?>"                         
								data-caption="<?php echo $projeto6->PRO_NOME; ?>">

								<div class="d-flex icon justify-content-center align-items-center">
									<span class="ion-md-search"></span>
								</div>
								<div class="d-flex heading align-items-end">
									<h3>
										<span><?php echo $projeto6->servicos->SER_NOME; ?></span><br>
										<?php echo $projeto6->PRO_NOME; ?>
									</h3>
								</div>
								<img src="<?php echo url::base().$img6[0]; ?>" class="img-fluid" alt="<?php echo $projeto6->PRO_NOME; ?>">
							</a>
							<div style="display: none;">
								<?php
								$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto6->PRO_ID."_%")->find_all();
								foreach($galeria as $key => $gal){
									$imgGal = glob("admin/".$gal->GAL_IMAGEM);
									if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto6->PRO_ID . "_")){ ?>
										<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
											data-fancybox="projeto_<?php echo $projeto6->PRO_ID; ?>"                         
											data-thumb="<?php echo url::base().$imgGal[0]; ?>"
											data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
										</a>
									<?php 
									} 
								} ?> 
							</div>
						<?php
						} ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<?php
						$img7 = glob('admin/upload/projetos/'.$projeto7->PRO_ID.'.*'); 
						if($img7){ ?>
							<a href="<?php echo url::base().$img7[0]; ?>" class="portfolio ftco-animate"
								data-fancybox="projeto_<?php echo $projeto7->PRO_ID; ?>"                         
								data-caption="<?php echo $projeto7->PRO_NOME; ?>">

								<div class="d-flex icon justify-content-center align-items-center">
									<span class="ion-md-search"></span>
								</div>
								<div class="d-flex heading align-items-end">
									<h3>
										<span><?php echo $projeto7->servicos->SER_NOME; ?></span><br>
										<?php echo $projeto7->PRO_NOME; ?>
									</h3>
								</div>
								<img src="<?php echo url::base().$img7[0]; ?>" class="img-fluid" alt="<?php echo $projeto7->PRO_NOME; ?>">
							</a>
							<div style="display: none;">
								<?php
								$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto7->PRO_ID."_%")->find_all();
								foreach($galeria as $key => $gal){
									$imgGal = glob("admin/".$gal->GAL_IMAGEM);
									if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto7->PRO_ID . "_")){ ?>
										<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
											data-fancybox="projeto_<?php echo $projeto7->PRO_ID; ?>"                         
											data-thumb="<?php echo url::base().$imgGal[0]; ?>"
											data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
										</a>
									<?php 
									} 
								} ?> 
							</div>
						<?php
						} ?>
					</div>
					<div class="col-md-4">
						<?php
						$img8 = glob('admin/upload/projetos/'.$projeto8->PRO_ID.'.*'); 
						if($img8){ ?>
							<a href="<?php echo url::base().$img8[0]; ?>" class="portfolio ftco-animate"
								data-fancybox="projeto_<?php echo $projeto8->PRO_ID; ?>"                         
								data-caption="<?php echo $projeto8->PRO_NOME; ?>">

								<div class="d-flex icon justify-content-center align-items-center">
									<span class="ion-md-search"></span>
								</div>
								<div class="d-flex heading align-items-end">
									<h3>
										<span><?php echo $projeto8->servicos->SER_NOME; ?></span><br>
										<?php echo $projeto8->PRO_NOME; ?>
									</h3>
								</div>
								<img src="<?php echo url::base().$img8[0]; ?>" class="img-fluid" alt="<?php echo $projeto8->PRO_NOME; ?>">
							</a>
							<div style="display: none;">
								<?php
								$galeria = ORM::factory("galeria")->where("GAL_IMAGEM", "like", "%fotos_projetos/thumb_".$projeto8->PRO_ID."_%")->find_all();
								foreach($galeria as $key => $gal){
									$imgGal = glob("admin/".$gal->GAL_IMAGEM);
									if($imgGal AND strpos($gal->GAL_IMAGEM, "thumb_" . $projeto8->PRO_ID . "_")){ ?>
										<a href="<?php echo url::base().str_replace("thumb_", "", $imgGal[0]); ?>"
											data-fancybox="projeto_<?php echo $projeto8->PRO_ID; ?>"                         
											data-thumb="<?php echo url::base().$imgGal[0]; ?>"
											data-caption="<?php echo $gal->GAL_LEGENDA; ?>">
										</a>
									<?php 
									} 
								} ?> 
							</div>
						<?php
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="testimony-section">
	<div class="container">
		<div class="row d-md-flex">
			<div class="col-md-4 last-order d-md-flex align-items-start heading-section aside-stretch ftco-animate">
				<div>
					<h3 class="mb-4">Clientes</h3>
					<p class="text-white font-italic">&ldquo;Se você vende algo para alguém, você tem um cliente HOJE.</p>
					<p class="text-white font-italic">Se você ajuda alguém, você tem um cliente PARA A VIDA TODA!&rdquo;</p>
				</div>
			</div>
			<div class="col-md-8 first-order ftco-animate">
				<div class="carousel-testimony owl-carousel">
					<?php 
					foreach($clientes as $cli){ 
						$imgCli = glob("admin/upload/clientes/thumb_".$cli->CLI_ID.".*");
						if($imgCli){ ?>
							<div class="item">
								<div class="testimony-wrap text-center">
									<div class="user-img mb-5" style="background-image: url(<?php echo $imgCli[0]; ?>)">
										<span class="quote d-flex align-items-center justify-content-center">
											<i class="icon-quote-left"></i>
										</span>
									</div>
									<div class="text">
										<p class="mb-5"><i><?php echo $cli->CLI_DEPOIMENTO; ?></i></p>
										<p class="name"><?php echo $cli->CLI_NOME; ?></p>
										<span class="position"><?php echo $cli->CLI_CARGO_EMPRESA; ?></span>
									</div>
								</div>
							</div>
						<?php
						}
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>