<!DOCTYPE html>
<html lang="pt-br">
	<head>
        <title><?php echo $titulo; ?></title>
        <meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    	<meta name="description" content="<?php echo $description; ?>" />
    	<meta name="keywords" content="<?php echo $keywords; ?>" />
		<meta name="robots" content="index, follow" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="RATING" content="GENERAL" />
    	<meta name="REVISIT-AFTER" content="2 days" />
    	<meta name="LANGUAGE" content="pt-br" />
		<meta name="GOOGLEBOT" content="INDEX, FOLLOW" />
		
		<!--Favicon-->
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo url::base(); ?>dist/img/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo url::base(); ?>dist/img/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo url::base(); ?>dist/img/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo url::base(); ?>dist/img/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo url::base(); ?>dist/img/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo url::base(); ?>dist/img/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo url::base(); ?>dist/img/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo url::base(); ?>dist/img/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo url::base(); ?>dist/img/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo url::base(); ?>dist/img/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo url::base(); ?>dist/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo url::base(); ?>dist/img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo url::base(); ?>dist/img/favicon-16x16.png">
        <link rel="manifest" href="<?php echo url::base(); ?>manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo url::base(); ?>dist/img/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <script type="text/javascript">
            var URLBASE = "<?php echo url::base() ?>";
        </script>
		
		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/open-iconic-bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/animate.css">
		
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/owl.theme.default.min.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/magnific-popup.css">

		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/aos.css">

		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/ionicons.min.css">

		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/jquery.timepicker.css">

		
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/flaticon.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/icomoon.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/fancybox.min.css">
		<link rel="stylesheet" href="<?php echo url::base(); ?>dist/css/style.css">

		<?php echo $analytics; ?>
	</head>
  <body data-spy="scroll">
    <!-- <div class="KW_progressContainer">
      <div class="KW_progressBar">

      </div>
    </div> -->
    <div class="page">
    <nav id="colorlib-main-nav" class="border" role="navigation">
      <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle active"><i></i></a>
      <div class="js-fullheight colorlib-table">
        <div class="img" style="background-image: url(dist/img/background_2.jpg);"></div>
        <div class="colorlib-table-cell js-fullheight">
          <div class="row no-gutters">
            <div class="col-md-12 text-center">
              	<h1 class="mb-4">
				  	<?php 
					$logo = glob('admin/upload/configuracoes/'.$id_logo.'.*');
					if($logo){ ?>
						<a href="<?php echo url::base(); ?>" class="logo">
							<img src="<?php echo url::base(); ?>dist/img/logo_costa_frame.png">
						</a>
					<?php
					} ?>
				</h1>
              <ul>
                <li><a href="<?php echo url::base(); ?>"><span>Home</span></a></li>
                <li><a href="<?php echo url::base(); ?>quemsomos"><span>Quem Somos</span></a></li>
                <li><a href="#" <?php if (Request::current()->controller() != "index"){ ?> onclick="location.href='<?php echo url::base(); ?>#services'" <?php }else{ ?> onclick="menuMaluco('#services');" <?php } ?>><span>Serviços</span></a></li>
                <li><a href="#" <?php if (Request::current()->controller() != "index"){ ?> onclick="location.href='<?php echo url::base(); ?>#projects'" <?php }else{ ?> onclick="menuMaluco('#projects');" <?php } ?>><span>Projetos</span></a></li>
                <li><a href="<?php echo url::base(); ?>contatos"><span>Contato</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    
    <div id="colorlib-page">
      <header>
        <div class="colorlib-navbar-brand">
          <a class="colorlib-logo" href="<?php echo url::base(); ?>">
			  <img src="<?php echo url::base(); ?>dist/img/logo_costa_frame.png">
		  </a>
        </div>
        <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
      </header>
	
		<?php echo $conteudo; ?>
		
		<!-- <section class="ftco-quote ftco-animate">
	    	<div class="container">
	    		<div class="row d-flex justify-content-end">
	    			<div class="col-md-8 req-quote d-md-flex py-5 align-items-center img" style="background-image: url(dist/img/bg_1.jpg);">
		    			<h3 class=" ml-md-3"></h3>
		    			<p><a href="#" class="btn btn-white py-4 px-4" data-toggle="modal" data-target="#modalRequest">Solicitar Contato</a></p>
	    			</div>
	    		</div>
	    	</div>
	    </section> -->
      
      <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
          <div class="row mb-5 justify-content-center">
            <div class="col-md-5 text-center">
              <div class="ftco-footer-widget mb-3">
                <ul class="ftco-footer-social list-unstyled">
                  <li class="ftco-animate"><a href="https://www.facebook.com/costaframeoficial/" target="_blank"><span class="icon-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="https://www.instagram.com/costaframe/" target="_blank"><span class="icon-instagram"></span></a></li>
                </ul>
              </div>
              <div class="ftco-footer-widget">
                <h2 class="mb-3">(54) 99936-6657 | (54) 99921-9922</h2>
                <p class="email"><a href="#">contato@costaframe.com</a></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center">

              <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos os direitos reservados | Costa Frame - Engenharia e Arquitetura
            </div>
          </div>
        </div>
      </footer>

      <!-- loader -->
      <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

      </div>

	    <!-- Modal -->
	    <div class="modal fade" id="modalRequest" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="modalRequestLabel">Request a Quote</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <form action="#">
	              <div class="form-group">
	                <label for="appointment_name" class="text-black">Full Name</label>
	                <input type="text" class="form-control" id="appointment_name">
	              </div>
	              <div class="form-group">
	                <label for="appointment_email" class="text-black">Email</label>
	                <input type="text" class="form-control" id="appointment_email">
	              </div>
	              <div class="row">
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="appointment_date" class="text-black">Date</label>
	                    <input type="text" class="form-control" id="appointment_date">
	                  </div>    
	                </div>
	                <div class="col-md-6">
	                  <div class="form-group">
	                    <label for="appointment_time" class="text-black">Time</label>
	                    <input type="text" class="form-control" id="appointment_time">
	                  </div>
	                </div>
	              </div>
	              

	              <div class="form-group">
	                <label for="appointment_message" class="text-black">Message</label>
	                <textarea name="" id="appointment_message" class="form-control" cols="30" rows="10"></textarea>
	              </div>
	              <div class="form-group">
	                <input type="submit" value="Send Message" class="btn btn-primary">
	              </div>
	            </form>
	          </div>
	          
	        </div>
	      </div>
	    </div>
    </div>

    <script src="<?php echo url::base(); ?>dist/js/jquery.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/popper.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/bootstrap.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery.easing.1.3.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery.waypoints.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery.stellar.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/owl.carousel.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/aos.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery.animateNumber.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/scrollax.min.js"></script>
	<script src="<?php echo url::base(); ?>dist/js/smoothscroll.min.js"></script>
	<script src="<?php echo url::base(); ?>dist/js/fancybox.min.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo url::base(); ?>dist/js/jquery.timepicker.min.js"></script>
	<script src="<?php echo url::base(); ?>dist/js/main.js"></script>
	
	<script>var URLBASE = '<?php echo url::base(); ?>';</script>
	<!--MASCARAS-->
	<script src="<?php echo url::base(); ?>dist/js/maskedmoney-1.3.min.js" type="text/javascript"></script>
	<script src="<?php echo url::base(); ?>dist/js/maskedinput-1.4.min.js" type="text/javascript"></script>
	<!--VALIDAR-->
	<script src="<?php echo url::base(); ?>dist/js/validar-1.3.5.js" type="text/javascript"></script>
	<!--forms-->
	<script defer src="<?php echo url::base(); ?>dist/js/forms_etc.js?v=256"></script>
	
	<!--[if IE]>
		<script src="<?php echo url::base(); ?>dist/js/html5shiv.js"></script>
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
  </body>
</html>