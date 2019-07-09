<section id="formulario">
    <div class="infos">
        <h1>Contatos</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>contatos/save" class="form-horizontal" id="formEdit" name="formEdit" method="post">
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="CON_ID" readonly name="CON_ID" value="<?php echo $contatos["CON_ID"] ?>">
    
        <div class="form-group">
            <label for="CON_DATA" class="col-sm-2 control-label">Data *</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" validar="data"  class="form-control data pequeno" placeholder="Data" value="<?php if($contatos) echo Controller_Index::aaaammdd_ddmmaaaa($contatos["CON_DATA"]) ?>" id="CON_DATA" name="CON_DATA">
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_NOME" class="col-sm-2 control-label">Nome *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Nome" value="<?php if($contatos) echo $contatos["CON_NOME"] ?>" id="CON_NOME" name="CON_NOME" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_EMAIL" class="col-sm-2 control-label">Email *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="email"  class="form-control  " placeholder="Email" value="<?php if($contatos) echo $contatos["CON_EMAIL"] ?>" id="CON_EMAIL" name="CON_EMAIL" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_FONE" class="col-sm-2 control-label">Fone *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Fone" value="<?php if($contatos) echo $contatos["CON_FONE"] ?>" id="CON_FONE" name="CON_FONE" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CON_MENSAGEM" class="col-sm-2 control-label">Mensagem *</label>
            <div class="col-sm-10">
                <textarea  class="form-control ckeditor" placeholder="Mensagem" id="CON_MENSAGEM" name="CON_MENSAGEM">
                    <?php if($contatos) echo $contatos["CON_MENSAGEM"] ?>
                </textarea>
            </div>
        </div>
                                        
                </div>

                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <!-- <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button> -->
                    <button type="reset" class="btn btn-danger" onClick="history.go(-1)" id="limpa" >Cancelar</button>
                </div></form>
        </div>
    </div>
</section>
                    
<script type="text/javascript" src="<?php echo url::base(); ?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo url::base(); ?>js/ckfinder/ckfinder.js"></script>

<script type="text/javascript">// <![CDATA[

// This is a check for the CKEditor class. If not defined, the paths must be checked.

if ( typeof CKEDITOR == "undefined" ){

    document.write(

        "<strong><span style='color: #ff0000'>Error</span>: CKEditor not found</strong>." +

        "This sample assumes that CKEditor (not included with CKFinder) is installed in" +

        "the '/ckeditor/' path. If you have it installed in a different place, just edit" +

        "this file, changing the wrong paths in the &lt;head&gt; (line 5) and the 'BasePath'" +

        "value (line 32)." ) ;

}else{

    var editorCON_MENSAGEM = CKEDITOR.replace( "CON_MENSAGEM" );
    CKFinder.setupCKEditor( editorCON_MENSAGEM, "<?php echo url::base()?>js/ckfinder/" ) ;
}
// ]]>
</script>