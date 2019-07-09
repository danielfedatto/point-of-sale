<!-- Content Wrapper. Contains page content -->
 
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <section class="col-lg-6 connectedSortable ui-sortable">
            <?php if($noticias){ 
                $icon = ORM::factory("modulos")->where("MOD_ID", "=", 23)->find();?>
                <div class="box">
                    <div class="box-header">
                        <!--CONTAS A PAGAR-->
                        <h3 class="box-title"><i class="<?php echo $icon->MOD_ICONE; ?>"></i> <?php echo $icon->MOD_NOME; ?> Recentes</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($noticias as $not){ ?>
                                        <tr>
                                            <td><?php echo $not->NOT_TITULO; ?></td>
                                            <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($not->NOT_DATA); ?></td>
                                        </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="6" align="center"><a href="<?php echo url::base(); ?>noticias">Ver mais <i class="fa fa-mail-forward"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            <?php } ?>
        </section>

        <section class="col-lg-6 connectedSortable ui-sortable">
            <!-- Calendar -->
            <div class="box box-solid bg-blue-gradient">
                <div class="box-header">
                    <i class="fa fa-calendar"></i>

                    <h3 class="box-title">Calendário</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <!-- button with a dropdown -->
                        <div class="btn-group">
<!--                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Novo evento</a></li>
                                <li><a href="#">Limpar Eventos</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Ver calendário</a></li>
                            </ul>-->
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
<!--                        <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>-->
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <!--The calendar -->
                    <div id="calendar" style="width: 100%"></div>
                </div>
            </div>

        </section>

    </div>

</section>

<script type="text/javascript">
    $(function () {
        $("#calendar").datepicker({
            language: 'pt-BR',
        });
    }); 
    
    $(document).ready(function(){
        $("tr .day").each(function(){ 
            var date = new Date();
            
            if(!$(this).hasClass("day old") && !$(this).hasClass("day new") ){
                if($(this).html() == date.getDate()){
                    $(this).attr("class", "active");
                }
            }
        });
    });
        
 
    
</script>