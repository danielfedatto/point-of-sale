<section id="formulario">
    <h1>Galeria - <?php echo $informacoes["titulo"]; ?></h1>

    <!--SE NECESSÁRIO, EXPLICAÇÃO-->
    <p>Arraste as imagens para o quadro.</p>

    <!--UPLOAD MULTIPLOS ARQUIVOS-->
    <div id="holder" onclick="$('#campofile').click();"></div>
    <p id="upload" class="hidden">
        <label>Drag &amp; drop not supported, but you can still upload via this input field:<br>
            <input type="file" id="campofile" multiple onchange="readfiles(this.files);">
        </label>
    </p>
    <p id="filereader">File API &amp; FileReader API not supported</p>
    <p id="formdata">XHR2's FormData is not supported</p>
    <p id="progress">XHR2's upload progress isn't supported</p>
    <p>Progresso do Upload: <progress id="uploadprogress" min="0" max="100" value="0">0</progress></p>

    <script type="text/javascript">
        var holder = document.getElementById('holder'),
                tests = {
            filereader: typeof FileReader != 'undefined',
            dnd: 'draggable' in document.createElement('span'),
            formdata: !!window.FormData,
            progress: "upload" in new XMLHttpRequest
        },
        support = {
            filereader: document.getElementById('filereader'),
            formdata: document.getElementById('formdata'),
            progress: document.getElementById('progress')
        },
        acceptedTypes = {
            'image/png': true,
            'image/jpeg': true,
            'image/gif': true
        },
        progress = document.getElementById('uploadprogress'),
                fileupload = document.getElementById('upload');

        "filereader formdata progress".split(' ').forEach(function(api) {
            if (tests[api] === false) {
                support[api].className = 'fail';
            } else {
                // FFS. I could have done el.hidden = true, but IE doesn't support
                // hidden, so I tried to create a polyfill that would extend the
                // Element.prototype, but then IE10 doesn't even give me access
                // to the Element object. Brilliant.
                support[api].className = 'hidden';
            }
        });

        function previewfile(file) {
            if (tests.filereader === true && acceptedTypes[file.type] === true) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var image = new Image();
                    image.src = event.target.result;
                    image.width = 250; // a fake resize
                    holder.appendChild(image);
                };

                reader.readAsDataURL(file);
            } else {
                holder.innerHTML += '<p>Uploaded ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
                console.log(file);
            }
        }

        function readfiles(files) {
            debugger;
            var formData = tests.formdata ? new FormData() : null;

            for (var i = 0; i < files.length; i++) {
                if (tests.formdata) {
                    formData.append('imagem', files[i]);
                    formData.append('id_item', '<?php echo $informacoes["id_item"] ?>');
                    formData.append('modulo', '<?php echo $informacoes["modulo"] ?>');
                    formData.append('diretorio', '<?php echo $informacoes["diretorio"] ?>');
                }
                previewfile(files[i]);

                // now post a new XHR request
                if (tests.formdata) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', URLBASE + 'galeria/save');
                    xhr.onload = function() {
                        progress.value = progress.innerHTML = 100;
                    };

                    if (tests.progress) {
                        xhr.upload.onprogress = function(event) {
                            if (event.lengthComputable) {
                                var complete = (event.loaded / event.total * 100 | 0);
                                progress.value = progress.innerHTML = complete;
                            }
                        }
                    }

                    xhr.send(formData);
                }
            }

            /*TESTA SE TERMINOU O UPLOAD*/
            var finish = setInterval(function() {
                if (progress.value == 100) {
                    clearInterval(finish);
                    location.href = URLBASE + "galeria/index/<?php echo $informacoes["modulo"] ?>/<?php echo $informacoes["id_item"] ?>";
                }
            }, 1000);
        }

        if (tests.dnd) {
            holder.ondragover = function() {
                this.className = 'hover';
                return false;
            };
            holder.ondragend = function() {
                this.className = '';
                return false;
            };
            holder.ondrop = function(e) {
                this.className = '';
                e.preventDefault();
                readfiles(e.dataTransfer.files);
            }
        } else {
            fileupload.className = 'hidden';
            fileupload.querySelector('input').onchange = function() {
                readfiles(this.files);
            };
        }

    </script>
    <!--FIM UPLOAD ARQUIVOS-->

    <?php if (count($fotos) > 0) { ?>
        <!--MOSTRA AS FOTOS ATUALMENTE CADASTRADAS. FORMULARIO PARA ALTERAÇÃO DA LEGENDA OU DA ORDEM-->
        <p>Clique na imagem para excluir.</p>
        <form class="padrao galeria" id="formFotos" name="formFotos" method="post" action="<?php echo url::base() ?>galeria/update" >

            <!--CAMPOS PARA IDENTIFICAO DA FOTO-->
            <input type="hidden" id="id_item" readonly name="id_item" value="<?php echo $informacoes["id_item"] ?>">
            <input type="hidden" id="modulo" readonly name="modulo" value="<?php echo $informacoes["modulo"] ?>">

            <ul class="fotos">
                <?php
                foreach ($fotos as $fot) {
                    //TESTA SE EH DESSE ID, JA QUE PELO BANCO NAO PUXA CERTO (1_ E 11_ DA NA MESMA)
                    if (strpos($fot->GAL_IMAGEM, "thumb_" . $informacoes["id_item"] . "_")) {

                        $img = glob($fot->GAL_IMAGEM);
                        if ($img) {
                            ?>
                            <li class="drag" style="width: 100%;">
                                <a onclick="
                                    if (window.confirm('Deseja realmente excluir essa imagem?')) {
                                        location.href = URLBASE + 'galeria/excluir/<?php echo $fot->GAL_ID ?>/<?php echo $informacoes["modulo"] ?>/<?php echo $informacoes["id_item"] ?>';
                                    }
                                   ">
                                    <img style="float: left; margin-right: 20px;" src="<?php echo url::base() ?><?php echo $img[0] ?>?v=<?php echo $cacheController; ?>" />

                                </a>

                                <input type="hidden" id="GAL_ID" readonly name="GAL_ID[]" value="<?php echo $fot->GAL_ID ?>">

                                <div class="contain-itens">
                                    <div class="item-form">
                                        <label class="control-label">Legenda</label>
                                        <input class="form-control" type="text" name="legenda[]" id="legenda" value="<?php echo $fot->GAL_LEGENDA ?>" />
                                    </div>

                                    <div class="item-form">
                                        <label class="control-label">Ordem*</label>
                                        <input class="form-control" type="text" name="ordem[]" id="ordem" label="Ordem" validar="int" value="<?php echo $fot->GAL_ORDEM ?>" />
                                    </div>
                                </div>
                            </li>
                            <hr class="col-xs-11">
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            
            <div class="box-footer">
                <p class="legenda"><em>*</em> Campos obrigatórios.</p>
                <button type="submit" class="btn pull-right btn-success" id="salvarGaleria">Salvar</button>
            </div>
        </form>
    <?php } ?>

    <script>

        var dragSrcEl = null;

        //MUDA A IMAGEM QUE APARECE QUANDO ARRASTA
        /*var dragIcon = document.createElement('img');
         dragIcon.src = 'logo.png';
         dragIcon.width = 100;
         e.dataTransfer.setDragImage(dragIcon, -10, -10);*/

        function handleDragStart(e) {
            // Target (this) element is the source node.
            this.style.opacity = '0.4';

            dragSrcEl = this;

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault(); // Necessary. Allows us to drop.
            }

            e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

            return false;
        }

        function handleDragEnter(e) {
            // this / e.target is the current hover target.
            this.classList.add('over');
        }

        function handleDragLeave(e) {
            this.classList.remove('over');  // this / e.target is previous target element.
        }

        function handleDrop(e) {
            // this/e.target is current target element.

            if (e.stopPropagation) {
                e.stopPropagation(); // Stops some browsers from redirecting.
                e.preventDefault();
            }

            // Don't do anything if dropping the same column we're dragging.
            if (dragSrcEl !== this) {
                // Set the source column's HTML to the HTML of the columnwe dropped on.
                dragSrcEl.innerHTML = this.innerHTML;
                this.innerHTML = e.dataTransfer.getData('text/html');
            }
            
            $(".drag").css("opacity", 1);
            
            //ATUALIZA AS ORDENS
            var ordem = 1;
            $(".drag").each(function(){
                $(this).find("input[id=ordem]").val(ordem);
                ordem++;
            });

            return false;
        }

        function handleDragEnd(e) {
            // this/e.target is the source node.

            [].forEach.call(cols, function(col) {
                col.classList.remove('over');
            });

            $(".drag").css("opacity", 1);
        }

        var cols = document.querySelectorAll('.drag');
        [].forEach.call(cols, function(col) {
            col.addEventListener('dragstart', handleDragStart, false);
            col.addEventListener('dragenter', handleDragEnter, false)
            col.addEventListener('dragover', handleDragOver, false);
            col.addEventListener('dragleave', handleDragLeave, false);
            col.addEventListener('drop', handleDrop, false);
            col.addEventListener('dragend', handleDragEnd, false);
        });
    </script>
</section>