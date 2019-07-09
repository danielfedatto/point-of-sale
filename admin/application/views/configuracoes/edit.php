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
                <textarea  class="form-control" placeholder="Keywords" id="CON_KEYWORDS" name="CON_KEYWORDS"><?php echo $configuracoes["CON_KEYWORDS"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_DESCRIPTION" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <textarea  class="form-control" placeholder="Description" id="CON_DESCRIPTION" name="CON_DESCRIPTION"><?php echo $configuracoes["CON_DESCRIPTION"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="CON_GOOGLE_ANALYTICS" class="col-sm-2 control-label">Google Analytics</label>
            <div class="col-sm-10">
                <textarea  class="form-control" placeholder="Google Analytics" id="CON_GOOGLE_ANALYTICS" name="CON_GOOGLE_ANALYTICS"><?php echo $configuracoes["CON_GOOGLE_ANALYTICS"] ?></textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="logo" class="col-sm-2 control-label">Logo</label>
            <div class="col-sm-10">
                <input type="file" id="logo" name="logo" onchange="return ShowImagePreview(this, 0, 'logo');">
                <div class="has-error">
                    <span class="help-block">Tamanho da imagem: 337 x 102px</span>
                </div>
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divlogoCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="logoCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="logoBlob" name="logoBlob" />
            <input type="text" name="logox1" id="logox1" style="display: none;">
            <input type="text" name="logoy1" id="logoy1" style="display: none;">
            <input type="text" name="logow" id="logow" style="width: 50px; display: none;">
            <input type="text" name="logoh" id="logoh" style="width: 50px; display: none;">
        </div><?php if($logo) echo $logo; ?>

        <div class="form-group">
            <label for="logofixo" class="col-sm-2 control-label">Logo Fixo</label>
            <div class="col-sm-10">
                <input type="file" id="logofixo" name="logofixo" onchange="return ShowImagePreview(this, 0, 'logofixo');">
                <div class="has-error">
                    <span class="help-block">Tamanho da imagem: 160 x 49px</span>
                </div>
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divlogofixoCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="logofixoCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="logofixoBlob" name="logofixoBlob" />
            <input type="text" name="logofixox1" id="logofixox1" style="display: none;">
            <input type="text" name="logofixoy1" id="logofixoy1" style="display: none;">
            <input type="text" name="logofixow" id="logofixow" style="width: 50px; display: none;">
            <input type="text" name="logofixoh" id="logofixoh" style="width: 50px; display: none;">
        </div><?php if($logofixo) echo $logofixo; ?>
                                    
                </div>

                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button>
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

    //var editorCON_KEYWORDS = CKEDITOR.replace( "CON_KEYWORDS" );
    //CKFinder.setupCKEditor( editorCON_KEYWORDS, "<?php echo url::base()?>js/ckfinder/" ) ;
    //var editorCON_DESCRIPTION = CKEDITOR.replace( "CON_DESCRIPTION" );
    //CKFinder.setupCKEditor( editorCON_DESCRIPTION, "<?php echo url::base()?>js/ckfinder/" ) ;
    //var editorCON_GOOGLE_ANALYTICS = CKEDITOR.replace( "CON_GOOGLE_ANALYTICS" );
    //CKFinder.setupCKEditor( editorCON_GOOGLE_ANALYTICS, "<?php echo url::base()?>js/ckfinder/" ) ;
}
// ]]>
</script>
                    
<!--REDIMENSIONAMENTO DA IMAGEM-->
<script src="<?php echo url::base() ?>js/jcrop/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="<?php echo url::base() ?>js/jcrop/css/jquery.Jcrop.css" type="text/css" />
<script>
    var imageLoader = document.getElementById("imageLoader");
    function HandleFileEvent(event, selection, id)
    {
        var img = new Image;
        img.onload = function(event) {
            UpdatePreviewCanvas(event, img, selection, id);
        };
        img.src = event.target.result;
    }

    function ShowImagePreview(object, selection, id)
    {
        //DESTROI JCROP
        if ($("#"+id+"Blob").val() !== "") {
            $("#"+id+"Canvas").data("Jcrop").destroy();
            $("#div"+id+"Canvas").append("<canvas id='"+id+"Canvas' class='previewcanvas' ></canvas>");
        }
                    
        if (typeof object.files === "undefined")
            return;

        var files = object.files;

        if (!(window.File && window.FileReader && window.FileList && window.Blob))
        {
            alert("The File APIs are not fully supported in this browser.");
            return false;
        }

        if (typeof FileReader === "undefined")
        {
            alert("Filereader undefined!");
            return false;
        }

        var file = files[0];

        if (file !== undefined && file != null && !(/image/i).test(file.type))
        {
            alert("File is not an image.");
            return false;
        }

        reader = new FileReader();
        reader.onload = function(event) {
            HandleFileEvent(event, selection, id)
        }
        reader.readAsDataURL(file);
    }

    //FUNÇÃO QUE FAZ ALGUMA COISA QUE EU DESCONHEÇO, MAS POSSIVELMENTE UTIL
    function dataURItoBlob(dataURI) {
        // convert base64 to raw binary data held in a string
        // doesnt handle URLEncoded DataURIs
        var byteString;
        if (dataURI.split(",")[0].indexOf("base64") >= 0)
            byteString = atob(dataURI.split(",")[1]);
        else
            byteString = unescape(dataURI.split(",")[1]);
        // separate out the mime component
        var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

        // write the bytes of the string to an ArrayBuffer
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        // write the ArrayBuffer to a blob, and youre done
        return new Blob([ab], {type: mimeString});
    }

    function UpdatePreviewCanvas(event, img, selection, id)
    {
        var canvas = document.getElementById(id+"Canvas");
        var context = canvas.getContext("2d");
        var world = new Object();
//        world.width = canvas.offsetWidth;
//        world.height = canvas.offsetHeight;
        world.width = 1000;
        world.height = 1000;

        var WidthDif = img.width - world.width;
        var HeightDif = img.height - world.height;

        var Scale = 0.0;
        if (WidthDif > HeightDif)
        {
            Scale = world.width / img.width;
        }
        else
        {
            Scale = world.height / img.height;
        }
        if (Scale > 1)
            Scale = 1;

        var UseWidth = Math.floor(img.width * Scale);
        var UseHeight = Math.floor(img.height * Scale);
        
        canvas.width = UseWidth;
        canvas.height = UseHeight;

        var x = Math.floor((world.width - UseWidth) / 2);
        var y = Math.floor((world.height - UseHeight) / 2);

        context.drawImage(img, 0, 0, img.width, img.height, 0, 0, UseWidth, UseHeight);

        //COLOCAR DE VOLTA NO INPUT
        if($("#"+id).val().search(".jpg") > 0 || $("#"+id).val().search(".jpeg") > 0 ||
            $("#"+id).val().search(".JPG") > 0 || $("#"+id).val().search(".JPEG") > 0){
            //SEGUNDO PARAMETRO: QUALIDADE. PADRÃO DOS NAVEGADORES É 0.92
            var dataURL = canvas.toDataURL("image/jpeg", 0.92);
        }else if($("#"+id).val().search(".png") > 0 || $("#"+id).val().search(".PNG") > 0){
            var dataURL = canvas.toDataURL("image/png", 0.5);
        }else{
            alert("Formato não suportado!");
            $("#"+id).val("");
            return false;
        }

        var blob = dataURItoBlob(dataURL);

        $("#"+id+"Blob").val(dataURL);
        
        //BGCOLOR: BLACK - DEIXA FUNDO PRETO QUANDO EDITA
        //BGCOLOR: TRANSPARENT: PERMITE SALVAR PNG COM FUNDO TRANSPARENT
        
        if(id === "logo"){
            var funcao = showCoordslogo;
        }
        
        $(canvas).Jcrop({
            bgColor: "transparent",
            bgOpacity: 0.7,
            onSelect: funcao
        });
    }
    function showCoordslogo(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#logox1").val(c.x);
        $("#logoy1").val(c.y);
        $("#logow").val(c.w);
        $("#logoh").val(c.h);
    }
</script>