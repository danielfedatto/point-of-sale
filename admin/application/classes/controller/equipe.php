<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Equipe extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Equipe";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("equipe/list");
        
        $ordem = "EQU_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $equipe = ORM::factory("equipe");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $equipe->setColumns(array("EQU_ID"=>"EQU_ID", "EQU_NOME"=>"EQU_NOME", "EQU_ORDEM"=>"EQU_ORDEM"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $equipe = $equipe->where("EQU_NOME", "like", "%".$this->sane($_GET["chave"])."%")->or_where("EQU_ORDEM", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $equipe->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($equipe, $this->qtdPagina);
        $view->equipe = $paginas["data"];
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
        $view = View::Factory("equipe/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $equipe = ORM::factory("equipe");
            $equipe = $equipe->where($equipe->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "EQU_ID" => $equipe->EQU_ID,
                "EQU_NOME" => $equipe->EQU_NOME,
                "EQU_CARGO" => $equipe->EQU_CARGO,
                "EQU_ORDEM" => $equipe->EQU_ORDEM,
            );
            
            $view->equipe = $arr;
                    
            //BUSCA A FOTO, SE HOUVER
            $foto = glob("upload/equipe/thumb_" . $equipe->EQU_ID . ".*");
            if ($foto) {
                $view->foto = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Foto</label>
                        <input type='checkbox' id='excluirFoto' name='excluirFoto'>
                        <img src='" . url::base() . $foto[0] . "'>
                    </div>";
            }
            else {
                $view->foto = false;
            }
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "EQU_ID" => "0",
                "EQU_NOME" => "",
                "EQU_CARGO" => "",
                "EQU_ORDEM" => "0",
            );
            
            $view->equipe = $arr;
            $view->foto = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $excluiFoto = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("EQU_ID") == "0" ){ 
            
            $equipe = ORM::factory("equipe");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "foto" or $campo == "fotoBlob" or $campo == "fotox1" or $campo == "fotoy1" or $campo == "fotow" or $campo == "fotoh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $equipe->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $equipe->save();
                $mensagem = "Registro inserido com sucesso!";

                //INSERE A FOTO, SE EXISTIR
                if ($this->request->post("fotoBlob") != "") {
                    $imgBlob = $this->request->post("fotoBlob");

                    if(strpos($this->request->post("fotoBlob"), "image/jpg") or strpos($this->request->post("fotoBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("fotoBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "".$equipe->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/equipe/".$imgName, $data);

                    //CROP
                    if($this->request->post("fotow") != "" and $this->request->post("fotow") > 0){
                        $img = Image::factory(DOCROOT."upload/equipe/".$imgName);
                        $img = $img->crop($this->request->post("fotow"), $this->request->post("fotoh"), $this->request->post("fotox1"), $this->request->post("fotoy1"))->save(DOCROOT."upload/equipe/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/equipe/".$imgName);
                    $imgName = "thumb_" . $equipe->pk() . ".".$ext;
                    $img->resize(410)->save(DOCROOT."upload/equipe/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $equipe = ORM::factory("equipe", $this->request->post("EQU_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($equipe->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirFoto") {
                        $excluiFoto = str_replace("'", "", $value);
                    }else if ($campo == "foto" or $campo == "fotoBlob" or $campo == "fotox1" or $campo == "fotoy1" or $campo == "fotow" or $campo == "fotoh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $equipe->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $equipe->save();
                            
                    //SE EXCLUIR FOTO ESTIVER MARCADO, EXCLUI A FOTO
                    if($excluiFoto == "on" or $this->request->post("fotoBlob") != ""){
                        $imgsT = glob("upload/equipe/thumb_" . $equipe->pk() . ".*");
                        $imgs = glob("upload/equipe/" . $equipe->pk() . ".*");

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
                    if ($this->request->post("fotoBlob") != "") {
                        $imgBlob = $this->request->post("fotoBlob");

                        if(strpos($this->request->post("fotoBlob"), "image/jpg") or strpos($this->request->post("fotoBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("fotoBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "".$equipe->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/equipe/".$imgName, $data);

                        //CROP
                        if($this->request->post("fotow") != "" and $this->request->post("fotow") > 0){
                            $img = Image::factory(DOCROOT."upload/equipe/".$imgName);
                            $img = $img->crop($this->request->post("fotow"), $this->request->post("fotoh"), $this->request->post("fotox1"), $this->request->post("fotoy1"))->save(DOCROOT."upload/equipe/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/equipe/".$imgName);
                        $imgName = "thumb_" . $equipe->pk() . ".".$ext;
                        $img->resize(410)->save(DOCROOT."upload/equipe/".$imgName);
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
        if($query or $this->request->post("fotoBlob") != "" or $excluiFoto){
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //EXCLUI FOTO
        $imgsT = glob("upload/equipe/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/equipe/" . $this->request->param("id") . ".*");

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
        $equipe = ORM::factory("equipe", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($equipe->loaded()){
            //DELETA
            $query = $equipe->delete();
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
                //EXCLUI FOTO
                $imgsT = glob("upload/equipe/thumb_" . $val . ".*");
                $imgs = glob("upload/equipe/" . $val . ".*");

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
                $equipe = ORM::factory("equipe", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($equipe->loaded()){
                    //DELETA
                    $query = $equipe->delete();
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

// End Equipe
