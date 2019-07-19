<section id="formulario">

    <div class="infos">
        <h1>Usuário</h1>
    </div>

    <div class="col-md-12">
        <div class="box box-info">
            <form class="form-horizontal" id="formEdit" name="formEdit" method="post" action="<?php echo url::base() ?>usuarios/save" enctype="multipart/form-data" >
                <div class="box-body">
                    
                    <input type="hidden" id="USU_ID" readonly name="USU_ID" value="<?php echo $usuario["USU_ID"] ?>">
                    
                    <div class="form-group">
                        <label for="USU_NOME" class="col-sm-2 control-label">Nome *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Nome" validar="texto" id="USU_NOME" name="USU_NOME" value="<?php echo $usuario["USU_NOME"] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="USU_CARGO" class="col-sm-2 control-label">Cargo *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Cargo" validar="texto" id="USU_CARGO" name="USU_CARGO" value="<?php echo $usuario["USU_CARGO"] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="USU_FACEBOOK" class="col-sm-2 control-label">Facebook</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Facebook" id="USU_FACEBOOK" name="USU_FACEBOOK" value="<?php echo $usuario["USU_FACEBOOK"] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="USU_INSTAGRAM" class="col-sm-2 control-label">Instagram</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Instagram" id="USU_INSTAGRAM" name="USU_INSTAGRAM" value="<?php echo $usuario["USU_INSTAGRAM"] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="USU_BEHANCE" class="col-sm-2 control-label">Behance</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Behance" id="USU_BEHANCE" name="USU_BEHANCE" value="<?php echo $usuario["USU_BEHANCE"] ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="USU_EMAIL" class="col-sm-2 control-label">E-mail *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="E-mail" validar="email" id="USU_EMAIL" name="USU_EMAIL" value="<?php echo $usuario["USU_EMAIL"] ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="PER_ID" class="col-sm-2 control-label">Permissão *</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" id="PER_ID" name="PER_ID">
                                <?php foreach ($permissoes as $per) { ?>
                                    <option value="<?php echo $per->PER_ID ?>" <?php if ($per->PER_ID == $usuario["PER_ID"]) echo "selected"; ?>>
                                        <?php echo $per->PER_NOME ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="USU_LOGIN" class="col-sm-2 control-label">Login *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Login" validar="texto" id="USU_LOGIN" name="USU_LOGIN" value="<?php echo $usuario["USU_LOGIN"] ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="USU_SENHA" class="col-sm-2 control-label">Senha *</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="Senha" id="USU_SENHA" name="USU_SENHA" <?php if ($usuario["USU_ID"] == "0") { ?> validar="senha" <?php } ?> onchange="validaIgual(this);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="USU_SENHA_C" class="col-sm-2 control-label">Confirme a Senha *</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" placeholder="Confirme a Senha" id="USU_SENHA_C" name="USU_SENHA_C" <?php if ($usuario["USU_ID"] == "0") { ?> validar="igual" validarIgual="#USU_SENHA" <?php } ?>>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="USU_DATA_CADASTRO" class="col-sm-2 control-label">Data Cadastro</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control data" data-mask="" data-inputmask="'alias': 'dd/mm/yyyy'" id="USU_DATA_CADASTRO" name="USU_DATA_CADASTRO" validar="data" value="<?php echo $usuario["USU_DATA_CADASTRO"] ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="foto" class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" id="foto" name="foto" onchange="return ShowImagePreview(this, 0, 'foto');">
                        </div>
                    </div>

                    <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
                    <div class="form-group" id="divfotoCanvas" >
                        <!--<label>Preview</label>-->
                        <!--PREVIEW DA IMAGEM-->
                        <canvas id="fotoCanvas" class="previewcanvas" width="0" height="0"> ></canvas>
                        <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
                        <input type="hidden" id="fotoBlob" name="fotoBlob" />
                        <input type="text" name="fotox1" id="fotox1" style="display: none;">
                        <input type="text" name="fotoy1" id="fotoy1" style="display: none;">
                        <input type="text" name="fotow" id="fotow" style="width: 50px; display: none;">
                        <input type="text" name="fotoh" id="fotoh" style="width: 50px; display: none;">
                    </div>

                    <?php if ($foto) echo $foto; ?>
                    
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

<script type="text/javascript">
    function validaIgual(valor) {
        if ($(valor).val().length > 0) {
            $("#" + valor.id).attr("validar", "senha");
            $("#" + valor.id + "_C").attr("validar", "igual");
            $("#" + valor.id + "_C").attr("validarIgual", "#" + valor.id);
        } else {
            $("#" + valor.id).removeAttr("validar");
            $("#" + valor.id + "_C").removeAttr("validar");
            $("#" + valor.id + "_C").removeAttr("validarIgual");
        }
    }
</script>


<!--REDIMENSIONAMENTO DA IMAGEM-->
<script src="<?php echo url::base() ?>js/jcrop/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="<?php echo url::base() ?>js/jcrop/css/jquery.Jcrop.css" type="text/css" />
<script>
                        var imageLoader = document.getElementById("imageLoader");
                        function HandleFileEvent(event, selection, id)
                        {
                            var img = new Image;
                            img.onload = function (event) {
                                UpdatePreviewCanvas(event, img, selection, id);
                            };
                            img.src = event.target.result;
                        }

                        function ShowImagePreview(object, selection, id)
                        {
                            //DESTROI JCROP
                            if ($("#" + id + "Blob").val() !== "") {
                                $("#" + id + "Canvas").data("Jcrop").destroy();
                                $("#div" + id + "Canvas").append("<canvas id='" + id + "Canvas' class='previewcanvas' ></canvas>");
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
                            reader.onload = function (event) {
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
                            var canvas = document.getElementById(id + "Canvas");
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
                            if ($("#" + id).val().search(".jpg") > 0 || $("#" + id).val().search(".jpeg") > 0 ||
                                    $("#" + id).val().search(".JPG") > 0 || $("#" + id).val().search(".JPEG") > 0) {
                                //SEGUNDO PARAMETRO: QUALIDADE. PADRÃO DOS NAVEGADORES É 0.92
                                var dataURL = canvas.toDataURL("image/jpeg", 0.92);
                            } else if ($("#" + id).val().search(".png") > 0 || $("#" + id).val().search(".PNG") > 0) {
                                var dataURL = canvas.toDataURL("image/png", 0.5);
                            } else {
                                alert("Formato não suportado!");
                                $("#" + id).val("");
                                return false;
                            }

                            var blob = dataURItoBlob(dataURL);

                            $("#" + id + "Blob").val(dataURL);

                            //BGCOLOR: BLACK - DEIXA FUNDO PRETO QUANDO EDITA
                            //BGCOLOR: TRANSPARENT: PERMITE SALVAR PNG COM FUNDO TRANSPARENT

                            if (id === "foto") {
                                var funcao = showCoordsfoto;
                            }

                            $(canvas).Jcrop({
                                bgColor: "transparent",
                                bgOpacity: 0.7,
                                onSelect: funcao
                            });
                        }
                        function showCoordsfoto(c) {
                            // variables can be accessed here as
                            // c.x, c.y, c.x2, c.y2, c.w, c.h
                            $("#fotox1").val(c.x);
                            $("#fotoy1").val(c.y);
                            $("#fotow").val(c.w);
                            $("#fotoh").val(c.h);
                        }
</script>