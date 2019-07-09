<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Configuracoes extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Configurações";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("configuracoes/list");
        
        $ordem = "CON_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $configuracoes = ORM::factory("configuracoes");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $configuracoes->setColumns(array("CON_ID"=>"CON_ID", "CON_EMPRESA"=>"CON_EMPRESA"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $configuracoes = $configuracoes->where("CON_EMPRESA", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $configuracoes->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($configuracoes, $this->qtdPagina);
        $view->configuracoes = $paginas["data"];
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
        $view = View::Factory("configuracoes/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $configuracoes = ORM::factory("configuracoes");
            $configuracoes = $configuracoes->where($configuracoes->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CON_ID" => $configuracoes->CON_ID,
                "CON_EMPRESA" => $configuracoes->CON_EMPRESA,
                "CON_KEYWORDS" => $configuracoes->CON_KEYWORDS,
                "CON_DESCRIPTION" => $configuracoes->CON_DESCRIPTION,
                "CON_GOOGLE_ANALYTICS" => $configuracoes->CON_GOOGLE_ANALYTICS,
            );
            
            $view->configuracoes = $arr;
                    
            //BUSCA A LOGO, SE HOUVER
            $logo = glob("upload/configuracoes/thumb_" . $configuracoes->CON_ID . ".*");
            if ($logo) {
                $view->logo = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Logo</label>
                        <input type='checkbox' id='excluirLogo' name='excluirLogo'>
                        <img src='" . url::base() . $logo[0] . "'>
                    </div>";
            }
            else {
                $view->logo = false;
            }
            //BUSCA A LOGO FIXA, SE HOUVER
            $logofixo = glob("upload/configuracoes/thumb_fixo_" . $configuracoes->CON_ID . ".*");
            if ($logofixo) {
                $view->logofixo = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Logo Fixo</label>
                        <input type='checkbox' id='excluirLogofixo' name='excluirLogofixo'>
                        <img src='" . url::base() . $logofixo[0] . "'>
                    </div>";
            }
            else {
                $view->logofixo = false;
            }
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CON_ID" => "0",
                "CON_EMPRESA" => "",
                "CON_KEYWORDS" => "",
                "CON_DESCRIPTION" => "",
                "CON_GOOGLE_ANALYTICS" => "",
            );
            
            $view->configuracoes = $arr;
            $view->logo = false;
            $view->logofixo = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $excluiLogo = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CON_ID") == "0" ){ 
            
            $configuracoes = ORM::factory("configuracoes");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "logo" or $campo == "logoBlob" or $campo == "logox1" or $campo == "logoy1" or $campo == "logow" or $campo == "logoh" or
                    $campo == "logofixo" or $campo == "logofixoBlob" or $campo == "logofixox1" or $campo == "logofixoy1" or $campo == "logofixow" or $campo == "logofixoh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $configuracoes->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $configuracoes->save();
                $mensagem = "Registro inserido com sucesso!";

                //INSERE A LOGO, SE EXISTIR
                if ($this->request->post("logoBlob") != "") {
                    $imgBlob = $this->request->post("logoBlob");

                    if(strpos($this->request->post("logoBlob"), "image/jpg") or strpos($this->request->post("logoBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("logoBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "".$configuracoes->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/configuracoes/".$imgName, $data);

                    //CROP
                    if($this->request->post("logow") != "" and $this->request->post("logow") > 0){
                        $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                        $img = $img->crop($this->request->post("logow"), $this->request->post("logoh"), $this->request->post("logox1"), $this->request->post("logoy1"))->save(DOCROOT."upload/configuracoes/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                    $imgName = "thumb_" . $configuracoes->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/configuracoes/".$imgName);
                }

                if ($this->request->post("logofixoBlob") != "") {
                    $imgBlob = $this->request->post("logofixoBlob");

                    if(strpos($this->request->post("logofixoBlob"), "image/jpg") or strpos($this->request->post("logofixoBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("logofixoBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "fixo_".$configuracoes->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/configuracoes/".$imgName, $data);

                    //CROP
                    if($this->request->post("logofixow") != "" and $this->request->post("logofixow") > 0){
                        $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                        $img = $img->crop($this->request->post("logofixow"), $this->request->post("logofixoh"), $this->request->post("logofixox1"), $this->request->post("logofixoy1"))->save(DOCROOT."upload/configuracoes/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                    $imgName = "thumb_fixo_" . $configuracoes->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/configuracoes/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $configuracoes = ORM::factory("configuracoes", $this->request->post("CON_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($configuracoes->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirLogofixo") {
                        $excluiLogo = str_replace("'", "", $value);
                    }else if ($campo == "logo" or $campo == "logoBlob" or $campo == "logox1" or $campo == "logoy1" or $campo == "logow" or $campo == "logoh" or
                                $campo == "logofixo" or $campo == "logofixoBlob" or $campo == "logofixox1" or $campo == "logofixoy1" or $campo == "logofixow" or $campo == "logofixoh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $configuracoes->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $configuracoes->save();
                            
                    //SE EXCLUIR LOGO ESTIVER MARCADO, EXCLUI A LOGO
                    if($excluiLogo == "on" or $this->request->post("logoBlob") != ""){
                        $imgsT = glob("upload/configuracoes/thumb_" . $configuracoes->pk() . ".*");
                        $imgs = glob("upload/configuracoes/" . $configuracoes->pk() . ".*");

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
                    if ($this->request->post("logoBlob") != "") {
                        $imgBlob = $this->request->post("logoBlob");

                        if(strpos($this->request->post("logoBlob"), "image/jpg") or strpos($this->request->post("logoBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("logoBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "".$configuracoes->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/configuracoes/".$imgName, $data);

                        //CROP
                        if($this->request->post("logow") != "" and $this->request->post("logow") > 0){
                            $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                            $img = $img->crop($this->request->post("logow"), $this->request->post("logoh"), $this->request->post("logox1"), $this->request->post("logoy1"))->save(DOCROOT."upload/configuracoes/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                        $imgName = "thumb_" . $configuracoes->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/configuracoes/".$imgName);
                    }

                    //SE EXCLUIR LOGO ESTIVER MARCADO, EXCLUI A LOGO
                    if($excluiLogo == "on" or $this->request->post("logofixoBlob") != ""){
                        $imgsT = glob("upload/configuracoes/thumb_fixo_" . $configuracoes->pk() . ".*");
                        $imgs = glob("upload/configuracoes/fixo_" . $configuracoes->pk() . ".*");

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

                    if ($this->request->post("logofixoBlob") != "") {
                        $imgBlob = $this->request->post("logofixoBlob");
    
                        if(strpos($this->request->post("logofixoBlob"), "image/jpg") or strpos($this->request->post("logofixoBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("logofixoBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }
    
                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);
    
                        //imagem tamanho normal
                        $imgName = "fixo_".$configuracoes->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/configuracoes/".$imgName, $data);
    
                        //CROP
                        if($this->request->post("logofixow") != "" and $this->request->post("logofixow") > 0){
                            $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                            $img = $img->crop($this->request->post("logofixow"), $this->request->post("logofixoh"), $this->request->post("logofixox1"), $this->request->post("logofixoy1"))->save(DOCROOT."upload/configuracoes/".$imgName);
                        }
    
                        //thumb
                        $img = Image::factory(DOCROOT."upload/configuracoes/".$imgName);
                        $imgName = "thumb_fixo_" . $configuracoes->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/configuracoes/".$imgName);
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
        if($query or $this->request->post("logoBlob") != "" or $excluiLogo){
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }
    }
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End Configurações
