<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Banners extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Banners";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("banners/list");
        
        $ordem = "BAN_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $banners = ORM::factory("banners");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $banners->setColumns(array("BAN_ID"=>"BAN_ID", "BAN_TITULO"=>"BAN_TITULO", "BAN_INICIO"=>"BAN_INICIO", "BAN_FIM"=>"BAN_FIM", "BAN_ORDEM"=>"BAN_ORDEM"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $banners = $banners->where("BAN_TITULO", "like", "%".$this->sane($_GET["chave"])."%")->or_where("BAN_INICIO", "like", "%".$this->sane($this->ddmmaaaa_aaaammdd(addslashes($_GET["chave"])))."%")->or_where("BAN_FIM", "like", "%".$this->sane($this->ddmmaaaa_aaaammdd(addslashes($_GET["chave"])))."%")->or_where("BAN_ORDEM", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $banners->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($banners, $this->qtdPagina);
        $view->banners = $paginas["data"];
        $view->pagination = $paginas["pagination"];
        
        $view->ordem = $ordem;
        $view->sentido = $sentido;

        //PASSA A MENSAGEM
        $view->mensagem = $mensagem;
        $view->erro = $erro;
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }

    //FORMULARIO DE CADASTRO
    public function action_edit(){
        //INSTANCIA A VIEW DE EDICAO
        $view = View::Factory("banners/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $banners = ORM::factory("banners");
            $banners = $banners->where($banners->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "BAN_ID" => $banners->BAN_ID,
                "BAN_TITULO" => $banners->BAN_TITULO,
                "BAN_INICIO" => $banners->BAN_INICIO,
                "BAN_FIM" => $banners->BAN_FIM,
                "BAN_ORDEM" => $banners->BAN_ORDEM,
            );
            
            $view->banners = $arr;
                    
            //BUSCA A BACKGROUND, SE HOUVER
            $background = glob("upload/banners/thumb_" . $banners->BAN_ID . ".*");
            if ($background) {
                $view->background = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Background</label>
                        <input type='checkbox' id='excluirBackground' name='excluirBackground'>
                        <img src='" . url::base() . $background[0] . "'>
                    </div>";
            }
            else {
                $view->background = false;
            }
                    
            //BUSCA A IMAGEM_TEXTO, SE HOUVER
            $imagem_texto = glob("upload/banners/imagem_texto_thumb_" . $banners->BAN_ID . ".*");
            if ($imagem_texto) {
                $view->imagem_texto = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Imagem Texto</label>
                        <input type='checkbox' id='excluirImagem_texto' name='excluirImagem_texto'>
                        <img src='" . url::base() . $imagem_texto[0] . "'>
                    </div>";
            }
            else {
                $view->imagem_texto = false;
            }
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "BAN_ID" => "0",
                "BAN_TITULO" => "",
                "BAN_INICIO" => date("Y-m-d"),
                "BAN_FIM" => date("Y-m-d"),
                "BAN_ORDEM" => "0",
            );
            
            $view->banners = $arr;
            $view->background = false;
            $view->imagem_texto = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $excluiBackground = false;
                
        $excluiImagem_texto = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("BAN_ID") == "0" ){ 
            
            $banners = ORM::factory("banners");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "background" or $campo == "backgroundBlob" or $campo == "backgroundx1" or $campo == "backgroundy1" or $campo == "backgroundw" or $campo == "backgroundh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }
                else if ($campo == "imagem_texto" or $campo == "imagem_textoBlob" or $campo == "imagem_textox1" or $campo == "imagem_textoy1" or $campo == "imagem_textow" or $campo == "imagem_textoh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $banners->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $banners->save();
                $mensagem = "Registro inserido com sucesso!";

                //INSERE A BACKGROUND, SE EXISTIR
                if ($this->request->post("backgroundBlob") != "") {
                    $imgBlob = $this->request->post("backgroundBlob");

                    if(strpos($this->request->post("backgroundBlob"), "image/jpg") or strpos($this->request->post("backgroundBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("backgroundBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "".$banners->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/banners/".$imgName, $data);

                    //CROP
                    if($this->request->post("backgroundw") != "" and $this->request->post("backgroundw") > 0){
                        $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                        $img = $img->crop($this->request->post("backgroundw"), $this->request->post("backgroundh"), $this->request->post("backgroundx1"), $this->request->post("backgroundy1"))->save(DOCROOT."upload/banners/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                    $imgName = "thumb_" . $banners->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/banners/".$imgName);
                }

                //INSERE A IMAGEM_TEXTO, SE EXISTIR
                if ($this->request->post("imagem_textoBlob") != "") {
                    $imgBlob = $this->request->post("imagem_textoBlob");

                    if(strpos($this->request->post("imagem_textoBlob"), "image/jpg") or strpos($this->request->post("imagem_textoBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("imagem_textoBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "imagem_texto_".$banners->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/banners/".$imgName, $data);

                    //CROP
                    if($this->request->post("imagem_textow") != "" and $this->request->post("imagem_textow") > 0){
                        $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                        $img = $img->crop($this->request->post("imagem_textow"), $this->request->post("imagem_textoh"), $this->request->post("imagem_textox1"), $this->request->post("imagem_textoy1"))->save(DOCROOT."upload/banners/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                    $imgName = "imagem_texto_thumb_" . $banners->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/banners/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $banners = ORM::factory("banners", $this->request->post("BAN_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($banners->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirBackground") {
                        $excluiBackground = str_replace("'", "", $value);
                    }else if ($campo == "background" or $campo == "backgroundBlob" or $campo == "backgroundx1" or $campo == "backgroundy1" or $campo == "backgroundw" or $campo == "backgroundh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }
                    else if ($campo == "excluirImagem_texto") {
                        $excluiImagem_texto = str_replace("'", "", $value);
                    }else if ($campo == "imagem_texto" or $campo == "imagem_textoBlob" or $campo == "imagem_textox1" or $campo == "imagem_textoy1" or $campo == "imagem_textow" or $campo == "imagem_textoh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $banners->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $banners->save();
                            
                    //SE EXCLUIR BACKGROUND ESTIVER MARCADO, EXCLUI A BACKGROUND
                    if($excluiBackground == "on" or $this->request->post("backgroundBlob") != ""){
                        $imgsT = glob("upload/banners/thumb_" . $banners->pk() . ".*");
                        $imgs = glob("upload/banners/" . $banners->pk() . ".*");

                        if($imgs){
                            foreach($imgs as $im){
                                unlink($im);
                            }
                        }

                        if($imgsT){
                            foreach($imgsT as $imT){
                                unlink($imT);
                            }
                        }
                    }

                    //INSERE A IMAGEM, SE EXISTIR
                    if ($this->request->post("backgroundBlob") != "") {
                        $imgBlob = $this->request->post("backgroundBlob");

                        if(strpos($this->request->post("backgroundBlob"), "image/jpg") or strpos($this->request->post("backgroundBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("backgroundBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "".$banners->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/banners/".$imgName, $data);

                        //CROP
                        if($this->request->post("backgroundw") != "" and $this->request->post("backgroundw") > 0){
                            $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                            $img = $img->crop($this->request->post("backgroundw"), $this->request->post("backgroundh"), $this->request->post("backgroundx1"), $this->request->post("backgroundy1"))->save(DOCROOT."upload/banners/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                        $imgName = "thumb_" . $banners->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/banners/".$imgName);
                    }
                            
                    //SE EXCLUIR IMAGEM_TEXTO ESTIVER MARCADO, EXCLUI A IMAGEM_TEXTO
                    if($excluiImagem_texto == "on" or $this->request->post("imagem_textoBlob") != ""){
                        $imgsT = glob("upload/banners/imagem_texto_thumb_" . $banners->pk() . ".*");
                        $imgs = glob("upload/banners/imagem_texto_" . $banners->pk() . ".*");

                        if($imgs){
                            foreach($imgs as $im){
                                unlink($im);
                            }
                        }

                        if($imgsT){
                            foreach($imgsT as $imT){
                                unlink($imT);
                            }
                        }
                    }

                    //INSERE A IMAGEM, SE EXISTIR
                    if ($this->request->post("imagem_textoBlob") != "") {
                        $imgBlob = $this->request->post("imagem_textoBlob");

                        if(strpos($this->request->post("imagem_textoBlob"), "image/jpg") or strpos($this->request->post("imagem_textoBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("imagem_textoBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "imagem_texto_".$banners->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/banners/".$imgName, $data);

                        //CROP
                        if($this->request->post("imagem_textow") != "" and $this->request->post("imagem_textow") > 0){
                            $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                            $img = $img->crop($this->request->post("imagem_textow"), $this->request->post("imagem_textoh"), $this->request->post("imagem_textox1"), $this->request->post("imagem_textoy1"))->save(DOCROOT."upload/banners/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/banners/".$imgName);
                        $imgName = "imagem_texto_thumb_" . $banners->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/banners/".$imgName);
                    }
                } catch (ORM_Validation_Exception $e){
                    $query = false;
                    $mensagem = $e->errors("models");
                }
            } else{
                $query = false;
                $mensagem = "Houve um problema, nenhuma alteração realizada!";
            }
        }
        
        //SE MENSAGEM FOR ARRAY, TRANSFORMA EM STRING
        if(is_array($mensagem)){
            $men = "";
            foreach($mensagem as $m){
                $men .= $m."<br>";
            }
            $mensagem = $men;
        }
        
        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if($query or $this->request->post("backgroundBlob") != "" or $excluiBackground or $this->request->post("imagem_textoBlob") != "" or $excluiImagem_texto){
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //EXCLUI BACKGROUND
        $imgsT = glob("upload/banners/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/banners/" . $this->request->param("id") . ".*");

        if($imgs){
            foreach($imgs as $im){
                unlink($im);
            }
        }

        if($imgsT){
            foreach($imgsT as $imT){
                unlink($imT);
            }
        }
        //EXCLUI IMAGEM_TEXTO
        $imgsT = glob("upload/banners/imagem_texto_thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/banners/imagem_texto_" . $this->request->param("id") . ".*");

        if($imgs){
            foreach($imgs as $im){
                unlink($im);
            }
        }

        if($imgsT){
            foreach($imgsT as $imT){
                unlink($imT);
            }
        }
        $banners = ORM::factory("banners", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($banners->loaded()){
            //DELETA
            $query = $banners->delete();
        }else{
            $query = false;
        }
        
        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if($query){
            $this->action_index("<p class='res-alert trash'>Registro excluído com sucesso!</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>Houve um problema!</p>", true);
        }
    }
    
    //EXCLUI TODOS REGISTROS MARCADOS
    public function action_excluirTodos() {$query = false;
        
        foreach ($this->request->post() as $value) {
            foreach($value as $val){
                //EXCLUI BACKGROUND
                $imgsT = glob("upload/banners/thumb_" . $val . ".*");
                $imgs = glob("upload/banners/" . $val . ".*");

                if($imgs){
                    foreach($imgs as $im){
                        unlink($im);
                    }
                }

                if($imgsT){
                    foreach($imgsT as $imT){
                        unlink($imT);
                    }
                }
                //EXCLUI IMAGEM_TEXTO
                $imgsT = glob("upload/banners/imagem_texto_thumb_" . $val . ".*");
                $imgs = glob("upload/banners/imagem_texto_" . $val . ".*");

                if($imgs){
                    foreach($imgs as $im){
                        unlink($im);
                    }
                }

                if($imgsT){
                    foreach($imgsT as $imT){
                        unlink($imT);
                    }
                }
                $banners = ORM::factory("banners", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($banners->loaded()){
                    //DELETA
                    $query = $banners->delete();
                }else{
                    $query = false;
                }
            }
        }
        
        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if ($query) {
            $this->action_index("<p class='res-alert trash'>Registros excluídos com sucesso!</p>", false);
        }
        else {
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>Houve um problema! Nenhum registro selecionado!</p>", true);
        }}
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End Banners
