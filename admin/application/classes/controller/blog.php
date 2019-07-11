<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Blog extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Blog";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("blog/list");
        
        $ordem = "BLO_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $blog = ORM::factory("blog")->with("usuarios");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $blog->setColumns(array("BLO_ID"=>"BLO_ID", "BLO_TITULO"=>"BLO_TITULO", "BLO_DATA_E_HORA"=>"BLO_DATA_E_HORA"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $blog = $blog->where("BLO_TITULO", "like", "%".$this->sane($_GET["chave"])."%")->or_where("BLO_DATA_E_HORA", "like", "%".$this->sane($_GET["chave"])."%")->or_where("USU_NOME", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $blog->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($blog, $this->qtdPagina);
        $view->blog = $paginas["data"];
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
        $view = View::Factory("blog/edit");
        
        $id = $this->request->param("id");

        //BUSCA CATEGORIAS
        $view->categorias = ORM::factory("categorias")->find_all();
        
        //BUSCA USUARIOS
        $view->usuarios = ORM::factory("usuarios")->find_all();
                            
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $blog = ORM::factory("blog");
            $blog = $blog->where($blog->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "BLO_ID" => $blog->BLO_ID,
                "BLO_TITULO" => $blog->BLO_TITULO,
                "BLO_TEXTO" => $blog->BLO_TEXTO,
                "USU_ID" => $blog->USU_ID,
            );
            
            $view->blog = $arr;
                    
            //BUSCA A IMAGEM, SE HOUVER
            $imagem = glob("upload/blog/thumb_" . $blog->BLO_ID . ".*");
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
                "BLO_ID" => "0",
                "BLO_TITULO" => "",
                "BLO_TEXTO" => "",
                "USU_ID" => "",
            );
            
            $view->blog = $arr;
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
        if($this->request->post("BLO_ID") == "0" ){ 
            
            $blog = ORM::factory("blog");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                if ($campo == "CAT_ID" or $campo == "imagem" or $campo == "imagemBlob" or $campo == "imagemx1" or $campo == "imagemy1" or $campo == "imagemw" or $campo == "imagemh") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }else{ 
                    $blog->$campo = $value;
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $blog->save();
                $mensagem = "Registro inserido com sucesso!";

                $i = 0;
                if(isset($post['CAT_ID'])){
                    if(is_array($post['CAT_ID'])){
                        foreach($post['CAT_ID'] as $lele){
                            $blogcategorias = ORM::factory('blogcategorias');
                            $blogcategorias->CAT_ID = $post['CAT_ID'][$i];
                            $blogcategorias->BLO_ID = $blog->BLO_ID;
                            $blogcategorias->save();
                            $i++;
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
                    $imgName = "".$blog->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/blog/".$imgName, $data);

                    //CROP
                    if($this->request->post("imagemw") != "" and $this->request->post("imagemw") > 0){
                        $img = Image::factory(DOCROOT."upload/blog/".$imgName);
                        $img = $img->crop($this->request->post("imagemw"), $this->request->post("imagemh"), $this->request->post("imagemx1"), $this->request->post("imagemy1"))->save(DOCROOT."upload/blog/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/blog/".$imgName);
                    $imgName = "thumb_" . $blog->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/blog/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $blog = ORM::factory("blog", $this->request->post("BLO_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($blog->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirImagem") {
                        $excluiImagem = str_replace("'", "", $value);
                    }else if ($campo == "CAT_ID" or $campo == "imagem" or $campo == "imagemBlob" or $campo == "imagemx1" or $campo == "imagemy1" or $campo == "imagemw" or $campo == "imagemh") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }else{ 
                        $blog->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $blog->save();

                    //apaga os antigos
                    $blogcategorias = ORM::factory('blogcategorias')->where('BLO_ID', '=', $this->request->post("BLO_ID"))->find_all();
                    foreach($blogcategorias as $blc){
                        $apagablogcategoria = ORM::factory('blogcategorias', $blc->BLC_ID);
                        if ($apagablogcategoria->loaded()){
                            //DELETA
                            $apagablogcategoria->delete();
                        }
                    }

                    $i = 0;
                    if(isset($post['CAT_ID'])){
                        if(is_array($post['CAT_ID'])){
                            foreach($post['CAT_ID'] as $lele){
                                $blogcategorias = ORM::factory('blogcategorias');
                                $blogcategorias->CAT_ID = $post['CAT_ID'][$i];
                                $blogcategorias->BLO_ID = $blog->BLO_ID;
                                $blogcategorias->save();
                                $i++;
                            }
                        }
                    }
                            
                    //SE EXCLUIR IMAGEM ESTIVER MARCADO, EXCLUI A IMAGEM
                    if($excluiImagem == "on" or $this->request->post("imagemBlob") != ""){
                        $imgsT = glob("upload/blog/thumb_" . $blog->pk() . ".*");
                        $imgs = glob("upload/blog/" . $blog->pk() . ".*");

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
                        $imgName = "".$blog->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/blog/".$imgName, $data);

                        //CROP
                        if($this->request->post("imagemw") != "" and $this->request->post("imagemw") > 0){
                            $img = Image::factory(DOCROOT."upload/blog/".$imgName);
                            $img = $img->crop($this->request->post("imagemw"), $this->request->post("imagemh"), $this->request->post("imagemx1"), $this->request->post("imagemy1"))->save(DOCROOT."upload/blog/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/blog/".$imgName);
                        $imgName = "thumb_" . $blog->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/blog/".$imgName);
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
        //VERIFICA SE EXISTEM BLOGCATEGORIAS NESSA BLOG. SE EXISTIR, NÃO DEIXA EXCLUIR
        $blogcategorias = ORM::factory("blogcategorias")->where("BLO_ID", "=", $this->request->param("id"))->count_all();
                        
        if ($blogcategorias > 0){
            $this->action_index("<p class='res-alert warning'>Existem Blog Categorias cadastrados nessa Blog! Nenhuma alteração realizada!</p>", true);
        }else{
                        
        //EXCLUI IMAGEM
        $imgsT = glob("upload/blog/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/blog/" . $this->request->param("id") . ".*");

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
        $blog = ORM::factory("blog", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($blog->loaded()){
            //DELETA
            $query = $blog->delete();
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
    }
    
    //EXCLUI TODOS REGISTROS MARCADOS
    public function action_excluirTodos() {$query = false;
        
        foreach ($this->request->post() as $value) {
            foreach($value as $val){
                //VERIFICA SE EXISTEM BLOGCATEGORIAS NESSA BLOG. SE EXISTIR, NÃO DEIXA EXCLUIR
                $blogcategorias = ORM::factory("blogcategorias")->where("BLO_ID", "=", $this->request->param("id"))->count_all();
                        
                if ($blogcategorias > 0){
                    $this->action_index("<p class='res-alert warning'>Existem Blog Categorias cadastrados nessa Blog! Nenhuma alteração realizada!</p>", true);
                    return true;
                }else{
                        
                //EXCLUI IMAGEM
                $imgsT = glob("upload/blog/thumb_" . $val . ".*");
                $imgs = glob("upload/blog/" . $val . ".*");

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
                $blog = ORM::factory("blog", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($blog->loaded()){
                    //DELETA
                    $query = $blog->delete();
                }else{
                    $query = false;
                }
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

// End Blog
