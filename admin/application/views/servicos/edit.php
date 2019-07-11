<section id="formulario">
    <div class="infos">
        <h1>A gente faz</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>servicos/save" class="form-horizontal" id="formEdit" name="formEdit" method="post" enctype="multipart/form-data" >
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="SER_ID" readonly name="SER_ID" value="<?php echo $servicos["SER_ID"] ?>">
    
        <div class="form-group">
            <label for="SER_TITULO" class="col-sm-2 control-label">Título *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Título" value="<?php if($servicos) echo $servicos["SER_TITULO"] ?>" id="SER_TITULO" name="SER_TITULO" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="SER_ORDEM" class="col-sm-2 control-label">Ordem*</label>
            <div class="col-sm-10">
                <input type="text" validar="int"  class="form-control pequeno" placeholder="Ordem" value="<?php if($servicos) echo $servicos["SER_ORDEM"] ?>" id="SER_ORDEM" name="SER_ORDEM">
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="SER_TEXTO" class="col-sm-2 control-label">Texto*</label>
            <div class="col-sm-10">
                <textarea  class="form-control ckeditor" placeholder="Texto" id="SER_TEXTO" name="SER_TEXTO">
                    <?php if($servicos) echo $servicos["SER_TEXTO"] ?>
                </textarea>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="imagem_home" class="col-sm-2 control-label">Imagem Home</label>
            <div class="col-sm-10">
                <input type="file" id="imagem_home" name="imagem_home" onchange="return ShowImagePreview(this, 0, 'imagem_home');">
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divimagem_homeCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="imagem_homeCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="imagem_homeBlob" name="imagem_homeBlob" />
            <input type="text" name="imagem_homex1" id="imagem_homex1" style="display: none;">
            <input type="text" name="imagem_homey1" id="imagem_homey1" style="display: none;">
            <input type="text" name="imagem_homew" id="imagem_homew" style="width: 50px; display: none;">
            <input type="text" name="imagem_homeh" id="imagem_homeh" style="width: 50px; display: none;">
        </div><?php if($imagem_home) echo $imagem_home; ?>
                                    
        <div class="form-group">
            <label for="imagem_interna" class="col-sm-2 control-label">Imagem Interna</label>
            <div class="col-sm-10">
                <input type="file" id="imagem_interna" name="imagem_interna" onchange="return ShowImagePreview(this, 0, 'imagem_interna');">
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divimagem_internaCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="imagem_internaCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="imagem_internaBlob" name="imagem_internaBlob" />
            <input type="text" name="imagem_internax1" id="imagem_internax1" style="display: none;">
            <input type="text" name="imagem_internay1" id="imagem_internay1" style="display: none;">
            <input type="text" name="imagem_internaw" id="imagem_internaw" style="width: 50px; display: none;">
            <input type="text" name="imagem_internah" id="imagem_internah" style="width: 50px; display: none;">
        </div><?php if($imagem_interna) echo $imagem_interna; ?>
                                    
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

    var editorSER_TEXTO = CKEDITOR.replace( "SER_TEXTO" );
    CKFinder.setupCKEditor( editorSER_TEXTO, "<?php echo url::base()?>js/ckfinder/" ) ;
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
        
        if(id === "imagem_home"){
            var funcao = showCoordsimagem_home;
        }
        else
        if(id === "imagem_interna"){
            var funcao = showCoordsimagem_interna;
        }
        
        $(canvas).Jcrop({
            bgColor: "transparent",
            bgOpacity: 0.7,
            onSelect: funcao
        });
    }
    function showCoordsimagem_home(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#imagem_homex1").val(c.x);
        $("#imagem_homey1").val(c.y);
        $("#imagem_homew").val(c.w);
        $("#imagem_homeh").val(c.h);
    }
    function showCoordsimagem_interna(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#imagem_internax1").val(c.x);
        $("#imagem_internay1").val(c.y);
        $("#imagem_internaw").val(c.w);
        $("#imagem_internah").val(c.h);
    }
</script>