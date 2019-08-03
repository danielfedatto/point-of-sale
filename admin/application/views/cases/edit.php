<section id="formulario">
    <div class="infos">
        <h1>Cases</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>cases/save" class="form-horizontal" id="formEdit" name="formEdit" method="post" enctype="multipart/form-data" >
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="CAS_ID" readonly name="CAS_ID" value="<?php echo $cases["CAS_ID"] ?>">
    
        <div class="form-group">
            <label for="CAS_TITULO" class="col-sm-2 control-label">Título *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Título" value="<?php if($cases) echo $cases["CAS_TITULO"] ?>" id="CAS_TITULO" name="CAS_TITULO" >
            </div>
        </div>

        <div class="form-group">
            <label for="CAS_SUBTITULO" class="col-sm-2 control-label">Subtítulo *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Subtítulo" value="<?php if($cases) echo $cases["CAS_SUBTITULO"] ?>" id="CAS_SUBTITULO" name="CAS_SUBTITULO" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="CAS_TEXTO" class="col-sm-2 control-label">Texto *</label>
            <div class="col-sm-10">
                <textarea  class="form-control ckeditor" placeholder="Texto" id="CAS_TEXTO" name="CAS_TEXTO">
                    <?php if($cases) echo $cases["CAS_TEXTO"] ?>
                </textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="CAS_DETALHES" class="col-sm-2 control-label">Detalhes *</label>
            <div class="col-sm-10">
                <textarea  class="form-control ckeditor" placeholder="Detalhes" id="CAS_DETALHES" name="CAS_DETALHES">
                    <?php if($cases) echo $cases["CAS_DETALHES"] ?>
                </textarea>
            </div>
        </div>
                                        
        <div class="form-group multiplo" label="Home">
            <label for="CAS_HOME" class="col-sm-2 control-label">Home *</label>
            <div class="col-sm-10">
            <input type="radio" name="CAS_HOME" <?php if ($cases["CAS_HOME"] == "S") echo "checked"; ?> id="HOMESim" value="S" validar="radio"> Sim &nbsp;&nbsp;&nbsp;
            <!--<label for="HOMESim" class="col-sm-2 control-label">Sim</label>-->
            <input type="radio" name="CAS_HOME" <?php if ($cases["CAS_HOME"] == "N") echo "checked"; ?> id="HOMENão" value="N" validar="radio"> Não &nbsp;&nbsp;&nbsp;
            <!--<label for="HOMENão" class="col-sm-2 control-label">Não</label>-->
            </div>
        </div>

        <div class="form-group">
            <label for="SER" class="col-sm-2 control-label">A gente faz *</label>
            <div class="col-sm-10">
                <?php 
                foreach($servicos as $ser){ 
                    $servicoscases = ORM::factory('servicoscases')->where('CAS_ID', '=', $cases["CAS_ID"])->where('SER_ID', '=', $ser->SER_ID)->find(); ?>
                    <input type="checkbox" value="<?php echo $ser->SER_ID ?>" <?php if($servicoscases->SER_ID > 0) echo 'checked'; ?> id="SER_ID_<?php echo $ser->SER_ID ?>" name="SER_ID[]"> <?php echo $ser->SER_TITULO ?> &nbsp;&nbsp;&nbsp;
                <?php 
                } ?>
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="imagem" class="col-sm-2 control-label">Imagem</label>
            <div class="col-sm-10">
                <input type="file" id="imagem" name="imagem" onchange="return ShowImagePreview(this, 0, 'imagem');">
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divimagemCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="imagemCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="imagemBlob" name="imagemBlob" />
            <input type="text" name="imagemx1" id="imagemx1" style="display: none;">
            <input type="text" name="imagemy1" id="imagemy1" style="display: none;">
            <input type="text" name="imagemw" id="imagemw" style="width: 50px; display: none;">
            <input type="text" name="imagemh" id="imagemh" style="width: 50px; display: none;">
        </div><?php if($imagem) echo $imagem; ?>
                                    
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

    var editorCAS_TEXTO = CKEDITOR.replace( "CAS_TEXTO" );
    CKFinder.setupCKEditor( editorCAS_TEXTO, "<?php echo url::base()?>js/ckfinder/" ) ;

    var editorCAS_DETALHES = CKEDITOR.replace( "CAS_DETALHES" );
    CKFinder.setupCKEditor( editorCAS_DETALHES, "<?php echo url::base()?>js/ckfinder/" ) ;
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
        
        if(id === "imagem"){
            var funcao = showCoordsimagem;
        }
        
        $(canvas).Jcrop({
            bgColor: "transparent",
            bgOpacity: 0.7,
            onSelect: funcao
        });
    }
    function showCoordsimagem(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#imagemx1").val(c.x);
        $("#imagemy1").val(c.y);
        $("#imagemw").val(c.w);
        $("#imagemh").val(c.h);
    }
</script>