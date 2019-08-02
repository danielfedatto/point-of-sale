<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Cases extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Cases";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("cases/list");
        
        $ordem = "CAS_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $cases = ORM::factory("cases");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $cases->setColumns(array("CAS_ID"=>"CAS_ID", "CAS_TITULO"=>"CAS_TITULO"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $cases = $cases->where("CAS_TITULO", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $cases->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($cases, $this->qtdPagina);
        $view->cases = $paginas["data"];
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
        $view = View::Factory("cases/edit");
        
        $id = $this->request->param("id");

        //BUSCA CATEGORIAS
        $view->servicos = ORM::factory("servicos")->find_all();
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $cases = ORM::factory("cases");
            $cases = $cases->where($cases->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CAS_ID" => $cases->CAS_ID,
                "CAS_TITULO" => $cases->CAS_TITULO,
                "CAS_TEXTO" => $cases->CAS_TEXTO,
                "CAS_HOME" => $cases->CAS_HOME,
            );
            
            $view->cases = $arr;
                    
            //BUSCA A IMAGEM, SE HOUVER
            $imagem = glob("upload/cases/thumb_" . $cases->CAS_ID . ".*");
            if ($imagem) {
                $view->imagem = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Imagem</label>
                        <input type='checkbox' id='excluirImagem' name='excluirImagem'>
                        <img src='" . url::base() . $imagem[0] . "'>
                    </div>";
            }
            else {
                $view->imagem = false;
            }
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CAS_ID" => "0",
                "CAS_TITULO" => "",
                "CAS_TEXTO" => "",
                "CAS_HOME" => "S",
            );
            
            $view->cases = $arr;
            $view->imagem = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $post = $this->request->post();

        $excluiImagem = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CAS_ID") == "0" ){ 
            
            $cases = ORM::factory("cases");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "SER_ID" or $campo == "imagem" or $campo == "imagemBlob" or $campo == "imagemx1" or $campo == "imagemy1" or $campo == "imagemw" or $campo == "imagemh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $cases->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $cases->save();

                $i = 0;
                if(isset($post['SER_ID'])){
                    if(is_array($post['SER_ID'])){
                        foreach($post['SER_ID'] as $lele){
                            $servicoscases = ORM::factory('servicoscases');
                            $servicoscases->SER_ID = $post['SER_ID'][$i];
                            $servicoscases->CAS_ID = $cases->CAS_ID;
                            $servicoscases->save();
                            $i++;
                        }
                    }
                }

                $mensagem = "Registro inserido com sucesso!";

                //INSERE A IMAGEM, SE EXISTIR
                if ($this->request->post("imagemBlob") != "") {
                    $imgBlob = $this->request->post("imagemBlob");

                    if(strpos($this->request->post("imagemBlob"), "image/jpg") or strpos($this->request->post("imagemBlob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("imagemBlob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "".$cases->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/cases/".$imgName, $data);

                    //CROP
                    if($this->request->post("imagemw") != "" and $this->request->post("imagemw") > 0){
                        $img = Image::factory(DOCROOT."upload/cases/".$imgName);
                        $img = $img->crop($this->request->post("imagemw"), $this->request->post("imagemh"), $this->request->post("imagemx1"), $this->request->post("imagemy1"))->save(DOCROOT."upload/cases/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/cases/".$imgName);
                    $imgName = "thumb_" . $cases->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/cases/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $cases = ORM::factory("cases", $this->request->post("CAS_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($cases->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirImagem") {
                        $excluiImagem = str_replace("'", "", $value);
                    }else if ($campo == "SER_ID" or $campo == "imagem" or $campo == "imagemBlob" or $campo == "imagemx1" or $campo == "imagemy1" or $campo == "imagemw" or $campo == "imagemh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $cases->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $cases->save();

                    //apaga os antigos
                    $servicoscases = ORM::factory('servicoscases')->where('CAS_ID', '=', $this->request->post("CAS_ID"))->find_all();
                    foreach($servicoscases as $sec){
                        $apagaservicoscases = ORM::factory('servicoscases', $sec->SEC_ID);
                        if ($apagaservicoscases->loaded()){
                            //DELETA
                            $apagaservicoscases->delete();
                        }
                    }

                    $i = 0;
                    if(isset($post['SER_ID'])){
                        if(is_array($post['SER_ID'])){
                            foreach($post['SER_ID'] as $lele){
                                $servicoscases = ORM::factory('servicoscases');
                                $servicoscases->SER_ID = $post['SER_ID'][$i];
                                $servicoscases->CAS_ID = $cases->CAS_ID;
                                $servicoscases->save();
                                $i++;
                            }
                        }
                    }
                            
                    //SE EXCLUIR IMAGEM ESTIVER MARCADO, EXCLUI A IMAGEM
                    if($excluiImagem == "on" or $this->request->post("imagemBlob") != ""){
                        $imgsT = glob("upload/cases/thumb_" . $cases->pk() . ".*");
                        $imgs = glob("upload/cases/" . $cases->pk() . ".*");

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
                    if ($this->request->post("imagemBlob") != "") {
                        $imgBlob = $this->request->post("imagemBlob");

                        if(strpos($this->request->post("imagemBlob"), "image/jpg") or strpos($this->request->post("imagemBlob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("imagemBlob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "".$cases->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/cases/".$imgName, $data);

                        //CROP
                        if($this->request->post("imagemw") != "" and $this->request->post("imagemw") > 0){
                            $img = Image::factory(DOCROOT."upload/cases/".$imgName);
                            $img = $img->crop($this->request->post("imagemw"), $this->request->post("imagemh"), $this->request->post("imagemx1"), $this->request->post("imagemy1"))->save(DOCROOT."upload/cases/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/cases/".$imgName);
                        $imgName = "thumb_" . $cases->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/cases/".$imgName);
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
        if($query or $this->request->post("imagemBlob") != "" or $excluiImagem){
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //EXCLUI IMAGEM
        $imgsT = glob("upload/cases/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/cases/" . $this->request->param("id") . ".*");

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
        $cases = ORM::factory("cases", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($cases->loaded()){
            //DELETA
            $query = $cases->delete();
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
                //EXCLUI IMAGEM
                $imgsT = glob("upload/cases/thumb_" . $val . ".*");
                $imgs = glob("upload/cases/" . $val . ".*");

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
                $cases = ORM::factory("cases", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($cases->loaded()){
                    //DELETA
                    $query = $cases->delete();
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

// End Cases
