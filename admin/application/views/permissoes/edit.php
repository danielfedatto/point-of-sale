<section id="formulario">
    
    <div class="infos">
        <h1>Permissão</h1>
    </div>

    <div class="col-md-12">
        <div class="box box-info">
            <form class="form-horizontal" id="formEdit" name="formEdit" method="post" action="<?php echo url::base() ?>permissoes/save">

                <div class="box-body">
                    
                    <input type="hidden" id="PER_ID" readonly name="PER_ID" value="<?php echo $permissao["PER_ID"] ?>">

                    <div class="form-group">
                        <label for="PER_NOME" class="col-sm-2 control-label">Nome *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nome" id="PER_NOME" name="PER_NOME" validar="texto" value="<?php echo $permissao["PER_NOME"] ?>">
                        </div>
                    </div>

                    <!--PARTE EXTRA: PERMISSOES NOS MODULOS-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Módulos</label>
                        <div class="col-sm-10">
                                <?php foreach ($modulos as $mod) { ?>
                                    <label>
                                        <input type="checkbox" id="mod-<?php echo $mod->MOD_ID ?>" name="MOD_ID[]" value="<?php echo $mod->MOD_ID ?>" <?php if (isset($mods[$mod->MOD_ID])) echo "checked"; ?> validar="radio"> <?php echo $mod->MOD_NOME ?>
                                    </label>
                                    <br/>
                                <?php } ?>
                        </div>
                    </div>

                </div>
                    
                <!-- /.box-body -->
                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button>
                    <button type="reset" class="btn btn-danger" onClick="history.go(-1)" id="limpa" >Cancelar</button>
                </div>
                <!-- /.box-footer -->

            </form>
        </div>
    </div>
</section>