<section id="formulario">
    <div class="infos">
        <h1>Servicos Cases</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>servicoscases/save" class="form-horizontal" id="formEdit" name="formEdit" method="post">
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="SEC_ID" readonly name="SEC_ID" value="<?php echo $servicoscases["SEC_ID"] ?>">
    
        <div class="form-group">
            <label for="CAS_ID" class="col-sm-2 control-label">Case *</label>
            <div class="col-sm-10">
                <select class="form-control select2" id="CAS_ID" name="CAS_ID" validar="int" >
                    <?php foreach($cases as $cas){ ?>
                    <option value="<?php echo $cas->CAS_ID ?>" <?php if($cas->CAS_ID == (int)$servicoscases["CAS_ID"]) echo "selected"; ?>>
                        <?php echo $cas->CAS_TITULO ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="SER_ID" class="col-sm-2 control-label">Servico *</label>
            <div class="col-sm-10">
                <select class="form-control select2" id="SER_ID" name="SER_ID" validar="int" >
                    <?php foreach($servicos as $ser){ ?>
                    <option value="<?php echo $ser->SER_ID ?>" <?php if($ser->SER_ID == (int)$servicoscases["SER_ID"]) echo "selected"; ?>>
                        <?php echo $ser->SER_TITULO ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
                                        
                </div>

                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button>
                    <button type="reset" class="btn btn-danger" onClick="history.go(-1)" id="limpa" >Cancelar</button>
                </div></form>
        </div>
    </div>
</section>