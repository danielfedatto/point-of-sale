<!DOCTYPE html>
<html lang="pt">
    <head>
        <title><?php echo $titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Paulo Knob - DEZ/2012" />
        <meta name="copyright" content="copyright (c) ows" />
        <meta http-equiv="X-UA-Compatible" content="IE=8,chrome=1" />

        <link href="<?php echo url::base(); ?>css/style.css" type="text/css" rel="stylesheet" />

        <script type="text/javascript">
            var URLBASE = "<?php echo url::base() ?>";
        </script>

        <!--JQUERY-->
        <script src="http://static.ows.com.br/libs/jquery/1.8.2/jquery-1.8.2.min.js" type="text/javascript"></script>
        <!--FIM JQUERY-->
    </head>
    <body >
        <div id="quatrocentos">
            <p class="numero">404</p>
            <div id="info">
                <img src="<?php echo url::base() ?>images/logo.png" alt="" class="logo">
                <p class="mensagem"><strong>Ops!</strong><br/>Página não encontrada.<br/><a href="<?php echo url::base() ?>">Voltar para o sistema</a></p>				
            </div>
        </div>
    </body>
</html>