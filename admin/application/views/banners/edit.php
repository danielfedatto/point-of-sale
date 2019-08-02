<section id="formulario">
    <div class="infos">
        <h1>Banners</h1>
    </div>
    
    <div class="col-md-12">
        <div class="box box-info">
            <form action="<?php echo url::base() ?>banners/save" class="form-horizontal" id="formEdit" name="formEdit" method="post" enctype="multipart/form-data" >
                
            <div class="box-body">
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->
                <input type="hidden" id="BAN_ID" readonly name="BAN_ID" value="<?php echo $banners["BAN_ID"] ?>">
    
        <div class="form-group">
            <label for="BAN_TITULO" class="col-sm-2 control-label">Título *</label>
            <div class="col-sm-10">
                
                <input type="text" validar="texto"  class="form-control  " placeholder="Título" value="<?php if($banners) echo $banners["BAN_TITULO"] ?>" id="BAN_TITULO" name="BAN_TITULO" >
            </div>
        </div>
                            
        <div class="form-group">
            <label for="BAN_INICIO" class="col-sm-2 control-label">Início *</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" validar="data"  class="form-control data pequeno" placeholder="Início" value="<?php if($banners) echo Controller_Index::aaaammdd_ddmmaaaa($banners["BAN_INICIO"]) ?>" id="BAN_INICIO" name="BAN_INICIO">
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="BAN_FIM" class="col-sm-2 control-label">Fim *</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" validar="data"  class="form-control data pequeno" placeholder="Fim" value="<?php if($banners) echo Controller_Index::aaaammdd_ddmmaaaa($banners["BAN_FIM"]) ?>" id="BAN_FIM" name="BAN_FIM">
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="BAN_ORDEM" class="col-sm-2 control-label">Ordem*</label>
            <div class="col-sm-10">
                <input type="text" validar="int"  class="form-control pequeno" placeholder="Ordem" value="<?php if($banners) echo $banners["BAN_ORDEM"] ?>" id="BAN_ORDEM" name="BAN_ORDEM">
            </div>
        </div>

        <div class="form-group multiplo" label="Página">
            <label for="BAN_PAGINA" class="col-sm-2 control-label">Página</label>
            <div class="col-sm-10">
            <input type="radio" name="BAN_PAGINA" <?php if ($banners["BAN_PAGINA"] == "home") echo "checked"; ?> id="BANNERhome" value="home" validar="radio"> Home &nbsp;&nbsp;&nbsp;
            <!--<label for="TESTESim" class="col-sm-2 control-label">Sim</label>-->
            <input type="radio" name="BAN_PAGINA" <?php if ($banners["BAN_PAGINA"] == "nos") echo "checked"; ?> id="BANNERNos" value="nos" validar="radio"> Nós &nbsp;&nbsp;&nbsp;
            <input type="radio" name="BAN_PAGINA" <?php if ($banners["BAN_PAGINA"] == "cases") echo "checked"; ?> id="BANNERCases" value="cases" validar="radio"> Cases &nbsp;&nbsp;&nbsp;
            <input type="radio" name="BAN_PAGINA" <?php if ($banners["BAN_PAGINA"] == "blog") echo "checked"; ?> id="BANNERBlog" value="blog" validar="radio"> Blog &nbsp;&nbsp;&nbsp;
            <input type="radio" name="BAN_PAGINA" <?php if ($banners["BAN_PAGINA"] == "contatos") echo "checked"; ?> id="BANNERContatos" value="contatos" validar="radio"> Contatos &nbsp;&nbsp;&nbsp;
            <!--<label for="TESTENão" class="col-sm-2 control-label">Não</label>-->
            </div>
        </div>

        <div class="form-group">
            <label for="BAN_TEXTO_BOTAO" class="col-sm-2 control-label">Texto Botão</label>
            <div class="col-sm-10">
                
                <input type="text"  class="form-control  " placeholder="Texto Botão" value="<?php if($banners) echo $banners["BAN_TEXTO_BOTAO"] ?>" id="BAN_TEXTO_BOTAO" name="BAN_TEXTO_BOTAO" >
            </div>
        </div>

        <div class="form-group">
            <label for="BAN_LINK_BOTAO" class="col-sm-2 control-label">Link Botão</label>
            <div class="col-sm-10">
                
                <input type="text"  class="form-control  " placeholder="Link Botão" value="<?php if($banners) echo $banners["BAN_LINK_BOTAO"] ?>" id="BAN_LINK_BOTAO" name="BAN_LINK_BOTAO" >
            </div>
        </div>
                                        
        <div class="form-group">
            <label for="background" class="col-sm-2 control-label">Background</label>
            <div class="col-sm-10">
                <input type="file" id="background" name="background" onchange="return ShowImagePreview(this, 0, 'background');">
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divbackgroundCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="backgroundCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="backgroundBlob" name="backgroundBlob" />
            <input type="text" name="backgroundx1" id="backgroundx1" style="display: none;">
            <input type="text" name="backgroundy1" id="backgroundy1" style="display: none;">
            <input type="text" name="backgroundw" id="backgroundw" style="width: 50px; display: none;">
            <input type="text" name="backgroundh" id="backgroundh" style="width: 50px; display: none;">
        </div><?php if($background) echo $background; ?>
                                    
        <div class="form-group">
            <label for="imagem_texto" class="col-sm-2 control-label">Imagem Texto</label>
            <div class="col-sm-10">
                <input type="file" id="imagem_texto" name="imagem_texto" onchange="return ShowImagePreview(this, 0, 'imagem_texto');">
            </div>
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="form-group" id="divimagem_textoCanvas" >
            <!--<label class="col-sm-2 control-label">Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="imagem_textoCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="imagem_textoBlob" name="imagem_textoBlob" />
            <input type="text" name="imagem_textox1" id="imagem_textox1" style="display: none;">
            <input type="text" name="imagem_textoy1" id="imagem_textoy1" style="display: none;">
            <input type="text" name="imagem_textow" id="imagem_textow" style="width: 50px; display: none;">
            <input type="text" name="imagem_textoh" id="imagem_textoh" style="width: 50px; display: none;">
        </div><?php if($imagem_texto) echo $imagem_texto; ?>
                                    
                </div>

                <div class="box-footer">
                    <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                    <button type="submit" class="btn pull-right btn-success" id="salvar">Salvar</button>
                    <button type="reset" class="btn btn-danger" onClick="history.go(-1)" id="limpa" >Cancelar</button>
                </div></form>
        </div>
    </div>
</section>
                    
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
        world.width = 4000;
        world.height = 4000;

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
        
        if(id === "background"){
            var funcao = showCoordsbackground;
        }
        else
        if(id === "imagem_texto"){
            var funcao = showCoordsimagem_texto;
        }
        
        $(canvas).Jcrop({
            bgColor: "transparent",
            bgOpacity: 0.7,
            onSelect: funcao
        });
    }
    function showCoordsbackground(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#backgroundx1").val(c.x);
        $("#backgroundy1").val(c.y);
        $("#backgroundw").val(c.w);
        $("#backgroundh").val(c.h);
    }
    function showCoordsimagem_texto(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#imagem_textox1").val(c.x);
        $("#imagem_textoy1").val(c.y);
        $("#imagem_textow").val(c.w);
        $("#imagem_textoh").val(c.h);
    }
</script>