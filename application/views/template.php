<!DOCTYPE html>
<html lang="pt-br">
	<head>
    <title><?php echo $titulo; ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="<?php echo $description; ?>" />
    <meta name="keywords" content="<?php echo $keywords; ?>" />
		<meta name="robots" content="all">
		<meta name="RATING" content="GENERAL">
		<meta name="REVISIT-AFTER" content="2 days">
		<meta name="LANGUAGE" content="pt-br">
		<meta name="GOOGLEBOT" content="INDEX, FOLLOW">
		<meta name="author" content="Daniel Fedatto">
		<meta name="copyright" content="Copyright (c) Linx">
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable = no">
		<meta name="application-name" content="<?php echo $titulo; ?>">
		<meta name="msapplication-TileColor" content="#FFFFFF">
		<meta name="msapplication-TileImage" content="<?php echo url::base() ?>dist/<?php echo url::base() ?>dist/img/mstile-144x144.png">
		<meta name="msapplication-square70x70logo" content="<?php echo url::base() ?>dist/img/mstile-70x70.png">
		<meta name="msapplication-square150x150logo" content="<?php echo url::base() ?>dist/img/mstile-150x150.png">
		<meta name="msapplication-wide310x150logo" content="<?php echo url::base() ?>dist/img/mstile-310x150.png">
		<meta name="msapplication-square310x310logo" content="<?php echo url::base() ?>dist/img/mstile-310x310.png">
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo url::base() ?>dist/img/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo url::base() ?>dist/img/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo url::base() ?>dist/img/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo url::base() ?>dist/img/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo url::base() ?>dist/img/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo url::base() ?>dist/img/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo url::base() ?>dist/img/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo url::base() ?>dist/img/apple-touch-icon-152x152.png">
		<link rel="icon" type="image/png" href="<?php echo url::base() ?>dist/img/favicon-196x196.png" sizes="196x196">
		<link rel="icon" type="image/png" href="<?php echo url::base() ?>dist/img/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="<?php echo url::base() ?>dist/img/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php echo url::base() ?>dist/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="<?php echo url::base() ?>dist/img/favicon-128x128.png" sizes="128x128">
    <link rel="stylesheet" type="text/css" href="<?php echo url::base() ?>dist/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo url::base() ?>dist/css/fancybox.min.css">

    <script type="text/javascript">
        var URLBASE = "<?php echo url::base() ?>";
    </script>

    <!--HEADER DO FACEBOOK-->
    <?php echo $faceHeader; ?>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.3&appId=2222804991343598">
    </script>

    <?php echo $analytics; ?>
	</head>
	<body>
    <div class="svg-icon_ui-lib">
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <symbol id="icon-pinterest" viewBox="0 0 32 32">
          <path d="M16.023 0c-8.828 0-15.984 7.156-15.984 15.983 0 6.772 4.211 12.556 10.157 14.883-0.14-1.265-0.265-3.204 0.055-4.585 0.292-1.249 1.875-7.943 1.875-7.943s-0.479-0.96-0.479-2.375c0-2.217 1.289-3.881 2.891-3.881 1.365 0 2.024 1.025 2.024 2.251 0 1.372-0.871 3.423-1.323 5.323-0.38 1.591 0.8 2.887 2.367 2.887 2.837 0 5.024-2.993 5.024-7.316 0-3.815-2.751-6.492-6.677-6.492-4.547 0-7.212 3.416-7.212 6.932 0 1.377 0.525 2.857 1.185 3.655 0.132 0.16 0.149 0.3 0.113 0.46-0.12 0.5-0.391 1.599-0.445 1.817-0.071 0.3-0.229 0.361-0.535 0.22-1.993-0.92-3.244-3.837-3.244-6.195 0-5.035 3.664-9.669 10.56-9.669 5.544 0 9.856 3.956 9.856 9.231 0 5.513-3.476 9.949-8.311 9.949-1.619 0-3.139-0.839-3.677-1.839l-0.999 3.797c-0.359 1.393-1.339 3.136-1.997 4.195 1.497 0.46 3.075 0.713 4.733 0.713 8.809 0 15.98-7.153 15.98-15.983 0-8.831-7.171-15.983-15.98-15.983l0.043-0.035z"></path>
        </symbol>
        <symbol id="icon-behance" viewBox="0 0 32 32">
          <path d="M9.251 6.004c0.936 0 1.787 0.080 2.56 0.251 0.769 0.173 1.427 0.44 1.98 0.813 0.547 0.373 0.977 0.867 1.28 1.493 0.3 0.627 0.453 1.4 0.453 2.307 0 0.987-0.227 1.813-0.676 2.48-0.451 0.667-1.116 1.2-2.003 1.627 1.208 0.347 2.101 0.96 2.696 1.827 0.597 0.88 0.887 1.933 0.887 3.147 0 1-0.173 1.853-0.547 2.573-0.373 0.733-0.893 1.333-1.547 1.8-0.64 0.464-1.4 0.8-2.227 1.023-0.813 0.22-1.669 0.339-2.547 0.339h-9.561v-19.669h9.251v-0.009zM22.587 22.22c0.587 0.571 1.431 0.857 2.525 0.857 0.787 0 1.467-0.197 2.040-0.596 0.565-0.387 0.907-0.813 1.040-1.253h3.451c-0.537 1.707-1.397 2.933-2.533 3.667-1.133 0.747-2.512 1.107-4.107 1.107-1.116 0-2.112-0.173-3.029-0.533-0.897-0.36-1.653-0.867-2.293-1.52-0.619-0.653-1.097-1.44-1.436-2.36-0.337-0.92-0.497-1.933-0.497-3.027 0-1.071 0.18-2.053 0.537-2.973 0.36-0.933 0.859-1.707 1.493-2.387 0.66-0.68 1.417-1.193 2.315-1.592s1.867-0.577 2.96-0.577c1.213 0 2.253 0.219 3.173 0.697 0.893 0.453 1.627 1.093 2.213 1.867 0.587 0.781 1 1.68 1.253 2.693 0.253 1 0.333 2.053 0.28 3.173h-10.253c0 1.12 0.373 2.176 0.947 2.753l-0.107 0.040zM8.933 22.287c0.423 0 0.827-0.040 1.208-0.124 0.387-0.080 0.731-0.22 1.017-0.4 0.28-0.18 0.52-0.437 0.693-0.777 0.173-0.32 0.253-0.76 0.253-1.28 0-1-0.293-1.72-0.853-2.16-0.573-0.427-1.32-0.64-2.253-0.64h-4.679v5.4h4.613v-0.040zM27.076 14.753c-0.469-0.513-1.253-0.789-2.209-0.789-0.624 0-1.14 0.099-1.555 0.317-0.403 0.2-0.733 0.467-0.987 0.787s-0.423 0.64-0.523 1c-0.1 0.347-0.16 0.667-0.18 0.947h6.349c-0.093-1-0.44-1.733-0.907-2.253v0.013zM8.693 13.933c0.765 0 1.4-0.179 1.9-0.549 0.499-0.36 0.739-0.96 0.739-1.784 0-0.459-0.093-0.833-0.24-1.128-0.173-0.293-0.4-0.52-0.667-0.683-0.28-0.165-0.6-0.28-0.96-0.343-0.36-0.071-0.747-0.099-1.12-0.099h-4.039v4.587h4.387zM20.824 7.323h7.957v1.939h-7.957v-1.941z"></path>
        </symbol>
        <symbol id="icon-facebook" viewBox="0 0 16 28">
          <path path d="M14.984 0.187v4.125h-2.453c-1.922 0-2.281 0.922-2.281 2.25v2.953h4.578l-0.609 4.625h-3.969v11.859h-4.781v-11.859h-3.984v-4.625h3.984v-3.406c0-3.953 2.422-6.109 5.953-6.109 1.687 0 3.141 0.125 3.563 0.187z"></path>
        </symbol>
        <symbol id="icon-instagram" viewBox="0 0 32 32">
          <path d="M16 0c-4.347 0-4.889 0.020-6.596 0.096-1.704 0.080-2.864 0.348-3.884 0.744-1.052 0.408-1.945 0.956-2.835 1.845s-1.439 1.781-1.845 2.835c-0.396 1.020-0.665 2.18-0.744 3.884-0.080 1.707-0.096 2.249-0.096 6.596s0.020 4.889 0.096 6.596c0.080 1.703 0.348 2.864 0.744 3.884 0.408 1.051 0.956 1.945 1.845 2.835 0.889 0.888 1.781 1.439 2.835 1.845 1.021 0.395 2.181 0.665 3.884 0.744 1.707 0.080 2.249 0.096 6.596 0.096s4.889-0.020 6.596-0.096c1.703-0.080 2.864-0.349 3.884-0.744 1.051-0.408 1.945-0.957 2.835-1.845 0.888-0.889 1.439-1.78 1.845-2.835 0.395-1.020 0.665-2.181 0.744-3.884 0.080-1.707 0.096-2.249 0.096-6.596s-0.020-4.889-0.096-6.596c-0.080-1.703-0.349-2.865-0.744-3.884-0.408-1.052-0.957-1.945-1.845-2.835-0.889-0.889-1.78-1.439-2.835-1.845-1.020-0.396-2.181-0.665-3.884-0.744-1.707-0.080-2.249-0.096-6.596-0.096zM16 2.88c4.271 0 4.78 0.021 6.467 0.095 1.56 0.073 2.407 0.332 2.969 0.553 0.749 0.289 1.28 0.636 1.843 1.195 0.559 0.56 0.905 1.092 1.195 1.841 0.219 0.563 0.48 1.409 0.551 2.969 0.076 1.688 0.093 2.195 0.093 6.467s-0.020 4.78-0.099 6.467c-0.081 1.56-0.341 2.407-0.561 2.969-0.299 0.749-0.639 1.28-1.199 1.843-0.559 0.559-1.099 0.905-1.84 1.195-0.56 0.219-1.42 0.48-2.98 0.551-1.699 0.076-2.199 0.093-6.479 0.093-4.281 0-4.781-0.020-6.479-0.099-1.561-0.081-2.421-0.341-2.981-0.561-0.759-0.299-1.28-0.639-1.839-1.199-0.561-0.559-0.92-1.099-1.2-1.84-0.22-0.56-0.479-1.42-0.56-2.98-0.060-1.68-0.081-2.199-0.081-6.459 0-4.261 0.021-4.781 0.081-6.481 0.081-1.56 0.34-2.419 0.56-2.979 0.28-0.76 0.639-1.28 1.2-1.841 0.559-0.559 1.080-0.919 1.839-1.197 0.56-0.221 1.401-0.481 2.961-0.561 1.7-0.060 2.2-0.080 6.479-0.080l0.060 0.040zM16 7.784c-4.54 0-8.216 3.68-8.216 8.216 0 4.54 3.68 8.216 8.216 8.216 4.54 0 8.216-3.68 8.216-8.216 0-4.54-3.68-8.216-8.216-8.216zM16 21.333c-2.947 0-5.333-2.387-5.333-5.333s2.387-5.333 5.333-5.333 5.333 2.387 5.333 5.333-2.387 5.333-5.333 5.333zM26.461 7.46c0 1.060-0.861 1.92-1.92 1.92-1.060 0-1.92-0.861-1.92-1.92s0.861-1.919 1.92-1.919c1.057-0.001 1.92 0.86 1.92 1.919z"></path>
        </symbol>
        <symbol id="icon-newsletter" viewBox="0 0 32 32">
          <path fill="#fff" d="M20.016 11.672v-1.688l-6.516 3.328-6.516-3.328v1.688l6.516 3.328zM20.016 8.016q0.797 0 1.383 0.586t0.586 1.383v9q0 0.797-0.586 1.406t-1.383 0.609h-13.031q-0.797 0-1.383-0.609t-0.586-1.406v-9q0-0.797 0.586-1.383t1.383-0.586h13.031zM18.844 6.984h-2.625l-5.719-3-6.516 3.422v9.609q-0.797 0-1.383-0.609t-0.586-1.406v-7.828q0-0.984 0.797-1.359l7.688-3.797 7.547 3.797q0.703 0.422 0.797 1.172z"></path>
        </symbol>
        <symbol id="icon-comments" viewBox="0 0 28 28">
          <path d="M11 6c-4.875 0-9 2.75-9 6 0 1.719 1.156 3.375 3.156 4.531l1.516 0.875-0.547 1.313c0.328-0.187 0.656-0.391 0.969-0.609l0.688-0.484 0.828 0.156c0.781 0.141 1.578 0.219 2.391 0.219 4.875 0 9-2.75 9-6s-4.125-6-9-6zM11 4c6.078 0 11 3.578 11 8s-4.922 8-11 8c-0.953 0-1.875-0.094-2.75-0.25-1.297 0.922-2.766 1.594-4.344 2-0.422 0.109-0.875 0.187-1.344 0.25h-0.047c-0.234 0-0.453-0.187-0.5-0.453v0c-0.063-0.297 0.141-0.484 0.313-0.688 0.609-0.688 1.297-1.297 1.828-2.594-2.531-1.469-4.156-3.734-4.156-6.266 0-4.422 4.922-8 11-8zM23.844 22.266c0.531 1.297 1.219 1.906 1.828 2.594 0.172 0.203 0.375 0.391 0.313 0.688v0c-0.063 0.281-0.297 0.484-0.547 0.453-0.469-0.063-0.922-0.141-1.344-0.25-1.578-0.406-3.047-1.078-4.344-2-0.875 0.156-1.797 0.25-2.75 0.25-2.828 0-5.422-0.781-7.375-2.063 0.453 0.031 0.922 0.063 1.375 0.063 3.359 0 6.531-0.969 8.953-2.719 2.609-1.906 4.047-4.484 4.047-7.281 0-0.812-0.125-1.609-0.359-2.375 2.641 1.453 4.359 3.766 4.359 6.375 0 2.547-1.625 4.797-4.156 6.266z"></path>
        </symbol>
        <symbol id="icon-access_time" viewBox="0 0 24 24">
          <path d="M12.516 6.984v5.25l4.5 2.672-0.75 1.266-5.25-3.188v-6h1.5zM12 20.016q3.281 0 5.648-2.367t2.367-5.648-2.367-5.648-5.648-2.367-5.648 2.367-2.367 5.648 2.367 5.648 5.648 2.367zM12 2.016q4.125 0 7.055 2.93t2.93 7.055-2.93 7.055-7.055 2.93-7.055-2.93-2.93-7.055 2.93-7.055 7.055-2.93z"></path>
        </symbol>
        <symbol id="icon-chevron_left" viewBox="0 0 24 24">
          <path fill="#a6a6a6" d="M15.422 7.406l-4.594 4.594 4.594 4.594-1.406 1.406-6-6 6-6z"></path>
        </symbol>
        <symbol id="icon-chevron_right" viewBox="0 0 24 24">
          <path fill="#a6a6a6" d="M9.984 6l6 6-6 6-1.406-1.406 4.594-4.594-4.594-4.594z"></path>
        </symbol>
        <symbol id="icon-share" viewBox="0 0 28 28">
          <path d="M28 10c0 0.266-0.109 0.516-0.297 0.703l-8 8c-0.187 0.187-0.438 0.297-0.703 0.297-0.547 0-1-0.453-1-1v-4h-3.5c-6.734 0-11.156 1.297-11.156 8.75 0 0.641 0.031 1.281 0.078 1.922 0.016 0.25 0.078 0.531 0.078 0.781 0 0.297-0.187 0.547-0.5 0.547-0.219 0-0.328-0.109-0.438-0.266-0.234-0.328-0.406-0.828-0.578-1.188-0.891-2-1.984-4.859-1.984-7.047 0-1.75 0.172-3.547 0.828-5.203 2.172-5.391 8.547-6.297 13.672-6.297h3.5v-4c0-0.547 0.453-1 1-1 0.266 0 0.516 0.109 0.703 0.297l8 8c0.187 0.187 0.297 0.438 0.297 0.703z"></path>
        </symbol>
      </svg>
    </div>
    <div id="mobile">
      <div class="stickerMob">
        <?php
          $logoCabecalho = glob("admin/upload/configuracoes/logo_cabecalho_".$CON_ID.".*");  
          if($logoCabecalho){ ?>
            <a href="<?php echo url::base(); ?>">
              <img class="logoMobile" src="<?php echo url::base().$logoCabecalho[0]; ?>" alt="Point of Sale">
            </a>
          <?php
          }
          ?>
        <div id="burgerBtn"></div>
      </div>
      <div id="nav">
        <ul>
          <li><a href="<?php echo url::base(); ?>" title="Home">Home</a></li>
          <li><a href="<?php echo url::base(); ?>nos" title="Quem somos">Nós</a></li>
          <li><a href="<?php echo url::base(); ?>cases" title="Cases">Cases</a></li>
          <li><a href="<?php echo url::base(); ?>blog" title="Blog">Blog</a></li>
          <li><a href="<?php echo url::base(); ?>contatos" title="Contato">Contato</a></li>
        </ul>
      </div>
    </div>
    <header>
      <?php
        if (Request::current()->controller() == "cases" or Request::current()->controller() == "blog" or Request::current()->controller() == "caseinterna"){
          $classeHeader = "header-internas";
        }
        else {
          $classeHeader = "";
        }
      ?>
      <div id="desk-nav" class="<?php echo $classeHeader; ?>">
        <div class="headerLinksWrap">
          <?php 
          if($logoCabecalho){ ?>
            <figure class="headerLogo">
              <a href="<?php echo url::base(); ?>">
                <img src="<?php echo url::base().$logoCabecalho[0]; ?>" alt="Point of Sale">
              </a>
            </figure>
          <?php
          } ?>
          <ul class="headerLinks">
            <li><a href="<?php echo url::base(); ?>" title="Página Inicial">Home</a></li>
            <li><a href="<?php echo url::base(); ?>nos" title="Sobre Nós">Nós</a></li>
            <li><a href="<?php echo url::base(); ?>cases" title="Cases">Cases</a></li>
            <li><a href="<?php echo url::base(); ?>blog" title="Blog">Blog</a></li>
            <li><a href="<?php echo url::base(); ?>contatos" title="Contato">Contato</a></li>
          </ul>
        </div>
      </div>
    </header>
    <section class="homeSlider">
      <div class="slider">
        <?php 
        foreach($banners as $ban){ 
          $imgBan = glob('admin/upload/banners/'.$ban->BAN_ID.'.*');
          if($imgBan){ ?>
            <div class="slide_<?php echo $ban->BAN_ID; ?>" style="background-image: url(<?php echo url::base().$imgBan[0]; ?>); background-size: cover">
              <div class="containerFluid">
                <div class="bannerContent">
                  <?php
                  $imgBan2 = glob('admin/upload/banners/imagem_texto_'.$ban->BAN_ID.'.*');
                  if($imgBan2){ ?>
                    <div class="figureSlide">
                      <figure><img src="<?php echo url::base().$imgBan2[0]; ?>" alt="<?php echo $ban->BAN_TITULO; ?>"></figure>
                    </div>
                  <?php
                  } 
                  if($ban->BAN_TEXTO_BOTAO != ""){ ?>
                    <div class="bannerButton"><a class="btnType1" href="<?php echo $ban->BAN_LINK_BOTAO; ?>"><?php echo $ban->BAN_TEXTO_BOTAO; ?></a></div>
                  <?php
                  } ?>
                </div>
              </div>
            </div>
          <?php 
          }
        } ?>
      </div>
    </section>

    <?php echo $conteudo; ?>
    
    <footer>
      <div class="container">
        <div class="footerBoxController">
          <div class="footerBoxLeft">
            <?php 
            $logoRodape = glob("admin/upload/configuracoes/logo_rodape_".$CON_ID.".*"); 
            if($logoRodape){ ?>
              <figure class="logoFooter">
                <img class="fluid-img" src="<?php echo url::base().$logoRodape[0]; ?>" alt="">
              </figure>
            <?php
            } ?>
            <ul class="socialMedia">
              <?php if($facebook != ''){ ?>
              <li><a href="<?php echo $facebook; ?>" target="_blank" title="Facebook"> 
                  <svg class="icon icon-facebook">
                    <use xlink:href="#icon-facebook"></use>
                  </svg></a></li>
              <?php } ?>
              <?php if($instagram != ''){ ?>
              <li><a href="<?php echo $instagram; ?>" target="_blank" title="Instagram"> 
                  <svg class="icon icon-instagram">
                    <use xlink:href="#icon-instagram"></use>
                  </svg></a></li>
              <?php } ?>
              <?php if($pinterest != ''){ ?>
              <li><a href="<?php echo $pinterest; ?>" target="_blank" title="Pinterest"> 
                  <svg class="icon icon-pinterest">
                    <use xlink:href="#icon-pinterest"></use>
                  </svg></a></li>
              <?php } ?>
              <?php if($behance != ''){ ?>
              <li><a href="<?php echo $behance; ?>" target="_blank" title="Behance"> 
                  <svg class="icon icon-behance">
                    <use xlink:href="#icon-behance"></use>
                  </svg></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="footerBoxRight">
            <form class="newsLetter" action="#" id="newsLetter">
              <h5>NEWSLETTER</h5>
              <p>Quer receber nossos conteúdos e ficar por dentro das novidades? Então cadastre-se!</p>
              <div class="inputControll form-group">
                <svg class="icon icon-newsletter">
                  <use xlink:href="#icon-newsletter"></use>
                </svg>
                <input type="text" name="NEW_EMAIL" id="NEW_EMAIL" label="E-mail" validar="email" value="" placeholder="Digite seu e-mail">
                <button class="btnType3" type="button" id="salvarNews">Inscrever</button>
                <div id="enviandoNews" style="display: none;">Enviando...</div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </footer>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="<?php echo url::base(); ?>dist/js/funcoes.min.js"></script>
</html>

<?php if (Request::current()->controller() == "contatos"){ ?>
<script>
	// GOOGLE MAPS

	function initMap(){
		var mapa;
		var ponto = new google.maps.LatLng(-28.2586515,-52.3960434,18);
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
			new google.maps.MarkerImage('dist/img/pin.png',
			new google.maps.Size(200, 200), 	//tamanho total
			new google.maps.Point(0, 0), 	//origem (se for sprite, é diferente de zero)
			new google.maps.Point(19, 25) 	//posição da "ponta" do alfinete
		);
		var marker = new google.maps.Marker({
			position: ponto,
			map: mapa,
			icon: image,
			url: 'https://www.google.com/maps/place/R.+Ant%C3%B4nio+Ara%C3%BAjo,+1046+-+802,+Passo+Fundo+-+RS,+99010-220/@-28.2586515,-52.3960434,18z/data=!4m13!1m7!3m6!1s0x94e2bf87ab6660dd:0x1c2ee8a757ff86a2!2sR.+Ant%C3%B4nio+Ara%C3%BAjo,+1046+-+802,+Passo+Fundo+-+RS,+99010-220!3b1!8m2!3d-28.2587693!4d-52.3956542!3m4!1s0x94e2bf87ab6660dd:0x1c2ee8a757ff86a2!8m2!3d-28.2587693!4d-52.3956542'
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
<?php } ?>