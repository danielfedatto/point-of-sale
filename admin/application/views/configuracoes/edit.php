<section id="formulario">
    <div class="infos">
        <h1>Configurações</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>configuracoes/save" class="form-horizontal" id="formEdit" name="formEdit" method="post" enctype="multipart/form-data" >
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="CON_ID" readonly name="CON_ID" value="<?php echo $configuracoes["CON_ID"] ?>">
    
        <div class="form-group">
            <label for="CON_EMPRESA" class="col-sm-2 control-label">Empresa *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Empresa" value="<?php if($configuracoes) echo $configuracoes["CON_EMPRESA"] ?>" id="CON_EMPRESA" name="CON_EMPRESA" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_KEYWORDS" class="col-sm-2 control-label">Keywords</label>
            <div class="col-sm-10">
                <textarea  class="form-control" placeholder="Keywords" id="CON_KEYWORDS" name="CON_KEYWORDS"><?php if($configuracoes) echo $configuracoes["CON_KEYWORDS"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_DESCRIPTION" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <textarea  class="form-control" placeholder="Description" id="CON_DESCRIPTION" name="CON_DESCRIPTION"><?php if($configuracoes) echo $configuracoes["CON_DESCRIPTION"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_GOOGLE_ANALYTICS" class="col-sm-2 control-label">Google Analytics *</label>
            <div class="col-sm-10">
                <textarea  class="form-control ckeditor" placeholder="Google Analytics" id="CON_GOOGLE_ANALYTICS" name="CON_GOOGLE_ANALYTICS"><?php if($configuracoes) echo $configuracoes["CON_GOOGLE_ANALYTICS"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_FACEBOOK" class="col-sm-2 control-label">Facebook</label>
            <div class="col-sm-10">
                
                <input type="text"   class="form-control  " placeholder="Facebook" value="<?php if($configuracoes) echo $configuracoes["CON_FACEBOOK"] ?>" id="CON_FACEBOOK" name="CON_FACEBOOK" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_INSTAGRAM" class="col-sm-2 control-label">Instagram</label>
            <div class="col-sm-10">
                
                <input type="text"   class="form-control  " placeholder="Instagram" value="<?php if($configuracoes) echo $configuracoes["CON_INSTAGRAM"] ?>" id="CON_INSTAGRAM" name="CON_INSTAGRAM" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_PINTREST" class="col-sm-2 control-label">Pinterest</label>
            <div class="col-sm-10">
                
                <input type="text"   class="form-control  " placeholder="Pinterest" value="<?php if($configuracoes) echo $configuracoes["CON_PINTREST"] ?>" id="CON_PINTREST" name="CON_PINTREST" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_BEHANCE" class="col-sm-2 control-label">Behance</label>
            <div class="col-sm-10">
                
                <input type="text"   class="form-control  " placeholder="Behance" value="<?php if($configuracoes) echo $configuracoes["CON_BEHANCE"] ?>" id="CON_BEHANCE" name="CON_BEHANCE" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_ENDERECO" class="col-sm-2 control-label">Endereço</label>
            <div class="col-sm-10">
                <textarea  class="form-control" placeholder="Endereço" id="CON_ENDERECO" name="CON_ENDERECO"><?php if($configuracoes) echo $configuracoes["CON_ENDERECO"] ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="CON_EMAIL" class="col-sm-2 control-label">E-mail *</label>
            <div class="col-sm-10">
                
                <input type="text" opcional="email"  class="form-control  " placeholder="E-mail" value="<?php if($configuracoes) echo $configuracoes["CON_EMAIL"] ?>" id="CON_EMAIL" name="CON_EMAIL" >
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_TELEFONE" class="col-sm-2 control-label">Telefone</label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                <input type="text"   class="form-control  fone" placeholder="Telefone" value="<?php if($configuracoes) echo $configuracoes["CON_TELEFONE"] ?>" id="CON_TELEFONE" name="CON_TELEFONE" onblur="verificaTelefone(this)">
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_HORARIO_ATENDIMENTO" class="col-sm-2 control-label">Horário Atendimento</label>
            <div class="col-sm-10">
                <textarea  class="form-control" placeholder="Horário Atendimento" id="CON_HORARIO_ATENDIMENTO" name="CON_HORARIO_ATENDIMENTO"><?php if($configuracoes) echo $configuracoes["CON_HORARIO_ATENDIMENTO"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="logo_cabecalho" class="col-sm-2 control-label">Logo Cabeçalho</label>
            <div class="col-sm-10">
                <input type="file" id="logo_cabecalho" name="logo_cabecalho" >
            </div>
        </div><?php if($logo_cabecalho) echo $logo_cabecalho; ?>
                                    
        <div class="form-group">
            <label for="logo_rodape" class="col-sm-2 control-label">Logo Rodapé</label>
            <div class="col-sm-10">
                <input type="file" id="logo_rodape" name="logo_rodape" >
            </div>
        </div><?php if($logo_rodape) echo $logo_rodape; ?>
                                    
                </div>

                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button>
                    <button type="reset" class="btn btn-danger" onClick="history.go(-1)" id="limpa" >Cancelar</button>
                </div></form>
        </div>
    </div>
</section>