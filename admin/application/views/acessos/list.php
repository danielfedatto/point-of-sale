<section id="lista">
    <h1>Acessos</h1>

    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if ($mensagem != "") { ?>
        <p><?php echo $mensagem ?></p>
    <?php } ?>

    <!--INCLUIR E PESQUISA-->
    <div class="operacoes">
        <form id="formExcel" name="formExcel" method="post" action="<?php echo url::base() ?>acessos/excel" style="float: right;" target="_blank">
            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>"/>
            <input type="hidden" name="inicio" value="<?php echo $inicio; ?>"/>
            <input type="hidden" name="fim" value="<?php echo $fim; ?>"/>
            <input type="hidden" name="modulo" value="<?php echo $modulo; ?>"/>
            <img onclick="$('#formExcel').submit();" src="<?php echo url::base() ?>images/excel.png" style="width: 31px; margin-left: 5px;">
        </form>
        <form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>acessos/pesquisa" class="pesquisa">
            <select name="usuario" id="usuario" style="float: left;">
                <option value="">Usuário...</option>
                <?php foreach ($usuariosfiltro as $usu) { ?>
                    <option value="<?php echo $usu->USU_ID; ?>" <?php if($usu->USU_ID == $usuario){ echo "selected"; } ?>><?php echo $usu->USU_NOME; ?></option>
                <?php } ?>
            </select>

            <input type="text" id="inicio" name="inicio" class="data" value="<?php echo Controller_Index::aaaammdd_ddmmaaaa($inicio); ?>" placeholder="Data Início"/>
            <input type="text" id="fim" name="fim" class="data" value="<?php echo Controller_Index::aaaammdd_ddmmaaaa($fim); ?>" placeholder="Data Fim"/>
            <input type="text" id="modulo" name="modulo"  value="<?php echo $modulo; ?>" placeholder="Módulo"/>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <!--LISTA DE REGISTROS-->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Usuário</th>
                            <th>IP</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Módulo</th>
                            <th>Ação</th>
                            <th>Item</th>
                            <th></th>
                        </tr>

                        <?php
                        //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
                        if (count($acessos) > 0) {
                            foreach ($acessos as $ace) {
                                ?>
                                <tr>
                                    <td class="codigo direita"><?php echo $ace->ACE_ID; ?></td>
                                    <td><?php echo $ace->usuarios->USU_NOME; ?></td>
                                    <td><?php echo $ace->ACE_IP; ?></td>
                                    <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($ace->ACE_DATA); ?></td>
                                    <td><?php echo $ace->ACE_HORA; ?></td>
                                    <td><?php echo $ace->ACE_MODULO; ?></td>
                                    <td><?php echo $ace->ACE_ACAO; ?></td>
                                    <td><?php echo $ace->ACE_ITEM; ?></td>
                                    <td>
                                        <?php if($ace->ACE_POST != ""){ ?>
                                            <a class="btn-inserir" title="Ver Detalhes" href="#" onclick="$('#modal-acessos-<?php echo $ace->ACE_ID; ?>').modal('show');"></a>
                                            <div class="modal modal-primary fade" id="modal-acessos-<?php echo $ace->ACE_ID; ?>" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <?php
                                                            $icon = ORM::factory("modulos")->where("MOD_ID", "=", 7)->find();
                                                            ?>
                                                            <h4 class="modal-title"><i class="<?php echo $icon->MOD_ICONE; ?>"></i> <?php echo $icon->MOD_NOME; ?> </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="box-body table-responsive">
                                                                <div class="box-body">
                                                                    <div class="row">
                                                                        <div class="col-xs-12">

                                                                            <div class="form-group">
                                                                                <label for="" class="col-sm-2 control-label">Post:</label>
                                                                                <div class="col-sm-10">
                                                                                    <?php echo $ace->ACE_POST; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- /.box-body -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="9" class="naoEncontrado">Nenhum acesso encontrado!</td>
                            </tr>
                            <?php
                        }
                        ?>

                    </table>
                </div>
        
                <!--EXCLUI TODOS MARCADOS-->
                <div class="operacoes">
                    <a onclick="
                        if (window.confirm('Deseja realmente excluir os registros marcados?')) {
                            excluirTodos('<?php echo Request::current()->controller(); ?>');
                        }
                       " class="btn-excluir-todos">Excluir todos marcados</a>
                </div>
                   
                <!--PAGINACAO-->
                <?php echo $pagination; ?>
    
            </div>
        </div>
    </div>
</section>

<!--ONDE MONTA O FORMULARIO PARA EXCLUIR OS MARCADOS-->
<div id="formExc"></div>