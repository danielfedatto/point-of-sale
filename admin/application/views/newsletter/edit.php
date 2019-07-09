<section id="formulario">
    <div class="infos">
        <h1>Newsletter</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>newsletter/save" class="form-horizontal" id="formEdit" name="formEdit" method="post">
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="NEW_ID" readonly name="NEW_ID" value="<?php echo $newsletter["NEW_ID"] ?>">
    
        <div class="form-group">
            <label for="NEW_EMAIL" class="col-sm-2 control-label">Email *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="email"  class="form-control  " placeholder="Email" value="<?php if($newsletter) echo $newsletter["NEW_EMAIL"] ?>" id="NEW_EMAIL" name="NEW_EMAIL" >
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