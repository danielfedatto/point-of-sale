<section id="formulario">
    
    <div class="infos">
        <h1>Categoria Módulo</h1>
    </div>    
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>categoriamodulo/save" class="form-horizontal" id="formEdit" name="formEdit" method="post">

                <div class="box-body">

                    <input type="hidden" id="CAM_ID" readonly name="CAM_ID" value="<?php echo $categoriamodulo["CAM_ID"] ?>">

                    <div class="form-group">
                        <label for="CAM_NOME" class="col-sm-2 control-label">Nome *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nome" validar="texto" value="<?php if($categoriamodulo) echo $categoriamodulo["CAM_NOME"] ?>" id="CAM_NOME" name="CAM_NOME">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="CAM_ORDEM" class="col-sm-2 control-label">Ordem *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Ordem" validar="int" value="<?php if($categoriamodulo) echo $categoriamodulo["CAM_ORDEM"] ?>" id="CAM_ORDEM" name="CAM_ORDEM">
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