<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Servicos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - A gente faz";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("servicos/list");
        
        $ordem = "SER_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $servicos = ORM::factory("servicos");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $servicos->setColumns(array("SER_ID"=>"SER_ID", "SER_TITULO"=>"SER_TITULO", "SER_ORDEM"=>"SER_ORDEM"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $servicos = $servicos->where("SER_TITULO", "like", "%".$this->sane($_GET["chave"])."%")->or_where("SER_ORDEM", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $servicos->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($servicos, $this->qtdPagina);
        $view->servicos = $paginas["data"];
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
        $view = View::Factory("servicos/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $servicos = ORM::factory("servicos");
            $servicos = $servicos->where($servicos->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "SER_ID" => $servicos->SER_ID,
                "SER_TITULO" => $servicos->SER_TITULO,
                "SER_ORDEM" => $servicos->SER_ORDEM,
                "SER_TEXTO" => $servicos->SER_TEXTO,
            );
            
            $view->servicos = $arr;
                    
            //BUSCA A IMAGEM_HOME, SE HOUVER
            $imagem_home = glob("upload/servicos/thumb_" . $servicos->SER_ID . ".*");
            if ($imagem_home) {
                $view->imagem_home = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Imagem Home</label>
                        <input type='checkbox' id='excluirImagem_home' name='excluirImagem_home'>
                        <img src='" . url::base() . $imagem_home[0] . "'>
                    </div>";
            }
            else {
                $view->imagem_home = false;
            }
                    
            //BUSCA A IMAGEM_INTERNA, SE HOUVER
            $imagem_interna = glob("upload/servicos/imagem_interna_thumb_" . $servicos->SER_ID . ".*");
            if ($imagem_interna) {
                $view->imagem_interna = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Imagem Interna</label>
                        <input type='checkbox' id='excluirImagem_interna' name='excluirImagem_interna'>
                        <img src='" . url::base() . $imagem_interna[0] . "'>
                    </div>";
            }
            else {
                $view->imagem_interna = false;
            }
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "SER_ID" => "0",
                "SER_TITULO" => "",
                "SER_ORDEM" => "0",
                "SER_TEXTO" => "",
            );
            
            $view->servicos = $arr;
            $view->imagem_home = false;
            $view->imagem_interna = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $excluiImagem_home = false;
                
        $excluiImagem_interna = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("SER_ID") == "0" ){ 
            
            $servicos = ORM::factory("servicos");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "imagem_home" or $campo == "imagem_homeBlob" or $campo == "imagem_homex1" or $campo == "imagem_homey1" or $campo == "imagem_homew" or $campo == "imagem_homeh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }
                else if ($campo == "imagem_interna" or $campo == "imagem_internaBlob" or $campo == "imagem_internax1" or $campo == "imagem_internay1" or $campo == "imagem_internaw" or $campo == "imagem_internah") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $servicos->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $servicos->save();
                $mensagem = "Registro inserido com sucesso!";

                //INSERE A IMAGEM_HOME, SE EXISTIR
                if ($this->request->post("imagem_homeBlob") != "") {
                    $imgBlob = $this->request->post("imagem_homeBlob");

                    if(strpos($this->request->post("imagem_homeBlob"), "image/jpg") or strpos($this->request->post("imagem_homeBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("imagem_homeBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "".$servicos->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/servicos/".$imgName, $data);

                    //CROP
                    if($this->request->post("imagem_homew") != "" and $this->request->post("imagem_homew") > 0){
                        $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                        $img = $img->crop($this->request->post("imagem_homew"), $this->request->post("imagem_homeh"), $this->request->post("imagem_homex1"), $this->request->post("imagem_homey1"))->save(DOCROOT."upload/servicos/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                    $imgName = "thumb_" . $servicos->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/servicos/".$imgName);
                }

                //INSERE A IMAGEM_INTERNA, SE EXISTIR
                if ($this->request->post("imagem_internaBlob") != "") {
                    $imgBlob = $this->request->post("imagem_internaBlob");

                    if(strpos($this->request->post("imagem_internaBlob"), "image/jpg") or strpos($this->request->post("imagem_internaBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("imagem_internaBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "imagem_interna_".$servicos->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/servicos/".$imgName, $data);

                    //CROP
                    if($this->request->post("imagem_internaw") != "" and $this->request->post("imagem_internaw") > 0){
                        $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                        $img = $img->crop($this->request->post("imagem_internaw"), $this->request->post("imagem_internah"), $this->request->post("imagem_internax1"), $this->request->post("imagem_internay1"))->save(DOCROOT."upload/servicos/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                    $imgName = "imagem_interna_thumb_" . $servicos->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/servicos/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $servicos = ORM::factory("servicos", $this->request->post("SER_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($servicos->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirImagem_home") {
                        $excluiImagem_home = str_replace("'", "", $value);
                    }else if ($campo == "imagem_home" or $campo == "imagem_homeBlob" or $campo == "imagem_homex1" or $campo == "imagem_homey1" or $campo == "imagem_homew" or $campo == "imagem_homeh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }
                    else if ($campo == "excluirImagem_interna") {
                        $excluiImagem_interna = str_replace("'", "", $value);
                    }else if ($campo == "imagem_interna" or $campo == "imagem_internaBlob" or $campo == "imagem_internax1" or $campo == "imagem_internay1" or $campo == "imagem_internaw" or $campo == "imagem_internah") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $servicos->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $servicos->save();
                            
                    //SE EXCLUIR IMAGEM_HOME ESTIVER MARCADO, EXCLUI A IMAGEM_HOME
                    if($excluiImagem_home == "on" or $this->request->post("imagem_homeBlob") != ""){
                        $imgsT = glob("upload/servicos/thumb_" . $servicos->pk() . ".*");
                        $imgs = glob("upload/servicos/" . $servicos->pk() . ".*");

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
                    if ($this->request->post("imagem_homeBlob") != "") {
                        $imgBlob = $this->request->post("imagem_homeBlob");

                        if(strpos($this->request->post("imagem_homeBlob"), "image/jpg") or strpos($this->request->post("imagem_homeBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("imagem_homeBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "".$servicos->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/servicos/".$imgName, $data);

                        //CROP
                        if($this->request->post("imagem_homew") != "" and $this->request->post("imagem_homew") > 0){
                            $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                            $img = $img->crop($this->request->post("imagem_homew"), $this->request->post("imagem_homeh"), $this->request->post("imagem_homex1"), $this->request->post("imagem_homey1"))->save(DOCROOT."upload/servicos/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                        $imgName = "thumb_" . $servicos->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/servicos/".$imgName);
                    }
                            
                    //SE EXCLUIR IMAGEM_INTERNA ESTIVER MARCADO, EXCLUI A IMAGEM_INTERNA
                    if($excluiImagem_interna == "on" or $this->request->post("imagem_internaBlob") != ""){
                        $imgsT = glob("upload/servicos/imagem_interna_thumb_" . $servicos->pk() . ".*");
                        $imgs = glob("upload/servicos/imagem_interna_" . $servicos->pk() . ".*");

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
                    if ($this->request->post("imagem_internaBlob") != "") {
                        $imgBlob = $this->request->post("imagem_internaBlob");

                        if(strpos($this->request->post("imagem_internaBlob"), "image/jpg") or strpos($this->request->post("imagem_internaBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("imagem_internaBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "imagem_interna_".$servicos->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/servicos/".$imgName, $data);

                        //CROP
                        if($this->request->post("imagem_internaw") != "" and $this->request->post("imagem_internaw") > 0){
                            $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                            $img = $img->crop($this->request->post("imagem_internaw"), $this->request->post("imagem_internah"), $this->request->post("imagem_internax1"), $this->request->post("imagem_internay1"))->save(DOCROOT."upload/servicos/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/servicos/".$imgName);
                        $imgName = "imagem_interna_thumb_" . $servicos->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/servicos/".$imgName);
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
        if($query or $this->request->post("imagem_homeBlob") != "" or $excluiImagem_home or $this->request->post("imagem_internaBlob") != "" or $excluiImagem_interna){
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //EXCLUI IMAGEM_HOME
        $imgsT = glob("upload/servicos/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/servicos/" . $this->request->param("id") . ".*");

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
        //EXCLUI IMAGEM_INTERNA
        $imgsT = glob("upload/servicos/imagem_interna_thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/servicos/imagem_interna_" . $this->request->param("id") . ".*");

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
        $servicos = ORM::factory("servicos", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($servicos->loaded()){
            //DELETA
            $query = $servicos->delete();
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
                //EXCLUI IMAGEM_HOME
                $imgsT = glob("upload/servicos/thumb_" . $val . ".*");
                $imgs = glob("upload/servicos/" . $val . ".*");

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
                //EXCLUI IMAGEM_INTERNA
                $imgsT = glob("upload/servicos/imagem_interna_thumb_" . $val . ".*");
                $imgs = glob("upload/servicos/imagem_interna_" . $val . ".*");

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
                $servicos = ORM::factory("servicos", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($servicos->loaded()){
                    //DELETA
                    $query = $servicos->delete();
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

// End Serviços
