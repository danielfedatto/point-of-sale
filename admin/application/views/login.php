<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $titulo; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link type="image/vnd.microsoft.icon" rel="shortcut icon" href="<?php echo url::base(); ?>images/faveicon.png">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo url::base() ?>bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo url::base(); ?>plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo url::base() ?>dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo url::base() ?>plugins/iCheck/square/blue.css">

        <meta name="msapplication-TileImage" content="<?php echo url::base(); ?>images/mstile-144x144.png">
        <meta name="msapplication-square70x70logo" content="<?php echo url::base(); ?>images/mstile-70x70.png">
        <meta name="msapplication-square150x150logo" content="<?php echo url::base(); ?>images/mstile-150x150.png">
        <meta name="msapplication-wide310x150logo" content="<?php echo url::base(); ?>images/mstile-310x150.png">
        <meta name="msapplication-square310x310logo" content="<?php echo url::base(); ?>images/mstile-310x310.png">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo url::base(); ?>images/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href=".<?php echo url::base(); ?>images/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo url::base(); ?>images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo url::base(); ?>images/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo url::base(); ?>images/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo url::base(); ?>images/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo url::base(); ?>images/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo url::base(); ?>images/apple-touch-icon-152x152.png">
        <link rel="icon" type="image/png" href="<?php echo url::base(); ?>images/favicon-196x196.png" sizes="196x196">
        <link rel="icon" type="image/png" href="<?php echo url::base(); ?>images/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="<?php echo url::base(); ?>images/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="<?php echo url::base(); ?>images/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php echo url::base(); ?>images/favicon-128x128.png" sizes="128x128">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <img style='width: 100%;' src="<?php echo url::base() ?>images/logo-main.svg" alt="">
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <!--<p class="login-box-msg">Sign in to start your session</p>-->

                <form action="" method="post" id="formLogin">
                    <div class="form-group has-feedback">
                        <input type="user" class="form-control" placeholder="Usuário" label="Usuário" id="login" name="login" validar="texto">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Senha" label="Senha" id="senha" name="senha"  validar="texto">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
<!--                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> Remember Me
                                </label>
                            </div>-->
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--<a href="#">Esqueci minha senha</a><br>-->

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        
        <script type="text/javascript">
            var URLBASE = "<?php echo url::base() ?>";
        </script>

        <!-- jQuery-->
        <script src="<?php echo url::base(); ?>js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo url::base() ?>bootstrap/js/bootstrap.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo url::base(); ?>plugins/select2/select2.full.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo url::base() ?>plugins/iCheck/icheck.min.js"></script>
        <!--MASCARAS-->
        <script src="<?php echo url::base(); ?>js/maskedmoney-1.3.min.js" type="text/javascript"></script>
        <script src="<?php echo url::base(); ?>js/maskedinput-1.4.min.js" type="text/javascript"></script>
        <!--JQUERY UI-->
        <script src="<?php echo url::base(); ?>js/jquery-ui.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo url::base(); ?>css/jquery-ui.css" type="text/css" media="" />
        <!--VALIDADOR-->
        <script src="<?php echo url::base(); ?>js/validar-1.3.5.js" type="text/javascript"></script>
        <!--forms-->
        <script src="<?php echo url::base(); ?>js/forms_etc.js"></script>
        
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
    <?php
    //DESCONECTA DO BANCO (POR GARANTIA)
    Database::instance()->disconnect();
    ?>
</html>