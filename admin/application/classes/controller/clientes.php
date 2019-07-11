<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Clientes extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Clientes";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("clientes/list");
        
        $ordem = "CLI_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $clientes = ORM::factory("clientes");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $clientes->setColumns(array("CLI_ID"=>"CLI_ID", "CLI_TITULO"=>"CLI_TITULO"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $clientes = $clientes->where("CLI_TITULO", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $clientes->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($clientes, $this->qtdPagina);
        $view->clientes = $paginas["data"];
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
        $view = View::Factory("clientes/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $clientes = ORM::factory("clientes");
            $clientes = $clientes->where($clientes->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CLI_ID" => $clientes->CLI_ID,
                "CLI_TITULO" => $clientes->CLI_TITULO,
                "CLI_LINK" => $clientes->CLI_LINK,
            );
            
            $view->clientes = $arr;
                    
            //BUSCA A LOGO, SE HOUVER
            $logo = glob("upload/clientes/thumb_" . $clientes->CLI_ID . ".*");
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
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CLI_ID" => "0",
                "CLI_TITULO" => "",
                "CLI_LINK" => "",
            );
            
            $view->clientes = $arr;
            $view->logo = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $excluiLogo = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CLI_ID") == "0" ){ 
            
            $clientes = ORM::factory("clientes");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "logo" or $campo == "logoBlob" or $campo == "logox1" or $campo == "logoy1" or $campo == "logow" or $campo == "logoh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $clientes->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $clientes->save();
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
                    $imgName = "".$clientes->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/clientes/".$imgName, $data);

                    //CROP
                    if($this->request->post("logow") != "" and $this->request->post("logow") > 0){
                        $img = Image::factory(DOCROOT."upload/clientes/".$imgName);
                        $img = $img->crop($this->request->post("logow"), $this->request->post("logoh"), $this->request->post("logox1"), $this->request->post("logoy1"))->save(DOCROOT."upload/clientes/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/clientes/".$imgName);
                    $imgName = "thumb_" . $clientes->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/clientes/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $clientes = ORM::factory("clientes", $this->request->post("CLI_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($clientes->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirLogo") {
                        $excluiLogo = str_replace("'", "", $value);
                    }else if ($campo == "logo" or $campo == "logoBlob" or $campo == "logox1" or $campo == "logoy1" or $campo == "logow" or $campo == "logoh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $clientes->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $clientes->save();
                            
                    //SE EXCLUIR LOGO ESTIVER MARCADO, EXCLUI A LOGO
                    if($excluiLogo == "on" or $this->request->post("logoBlob") != ""){
                        $imgsT = glob("upload/clientes/thumb_" . $clientes->pk() . ".*");
                        $imgs = glob("upload/clientes/" . $clientes->pk() . ".*");

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
                        $imgName = "".$clientes->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/clientes/".$imgName, $data);

                        //CROP
                        if($this->request->post("logow") != "" and $this->request->post("logow") > 0){
                            $img = Image::factory(DOCROOT."upload/clientes/".$imgName);
                            $img = $img->crop($this->request->post("logow"), $this->request->post("logoh"), $this->request->post("logox1"), $this->request->post("logoy1"))->save(DOCROOT."upload/clientes/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/clientes/".$imgName);
                        $imgName = "thumb_" . $clientes->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/clientes/".$imgName);
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
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //EXCLUI LOGO
        $imgsT = glob("upload/clientes/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/clientes/" . $this->request->param("id") . ".*");

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
        $clientes = ORM::factory("clientes", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($clientes->loaded()){
            //DELETA
            $query = $clientes->delete();
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
                //EXCLUI LOGO
                $imgsT = glob("upload/clientes/thumb_" . $val . ".*");
                $imgs = glob("upload/clientes/" . $val . ".*");

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
                $clientes = ORM::factory("clientes", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($clientes->loaded()){
                    //DELETA
                    $query = $clientes->delete();
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

// End Clientes
