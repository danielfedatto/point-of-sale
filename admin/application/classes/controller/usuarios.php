<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Usuarios extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - USUÁRIOS";

        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {
        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory('usuarios/list');

        //BUSCA OS REGISTROS        
        $usuarios = ORM::factory('usuarios')->with('permissoes');

        //SETA AS COLUNAS QUE VAI BUSCAR
        $usuarios->setColumns(array("USU_ID" => "USU_ID", "USU_NOME" => "USU_NOME", "USU_LOGIN" => "USU_LOGIN"));

        //TESTA SE TEM PESQUISA
        if (isset($_GET["chave"])) {
            $usuarios = $usuarios->where("USU_NOME", "like", "%" . $this->sane($_GET["chave"]) . "%");
        }

        //PAGINAÇÃO
        $paginas = $this->action_page($usuarios, $this->qtdPagina);
        $view->usuarios = $paginas["data"];
        $view->pagination = $paginas["pagination"];

        //PASSA A MENSAGEM
        $view->mensagem = $mensagem;
        $view->erro = $erro;

        $this->template->bt_voltar = true;

        $this->template->conteudo = $view;
    }

    //FORMULARIO DE CADASTRO
    public function action_edit() {
        //INSTANCIA A VIEW DE EDICAO
        $view = View::Factory('usuarios/edit');

        $id = $this->request->param("id");

        //BUSCA AS PERMISSÕES
        $view->permissoes = ORM::factory("permissoes")->find_all();

        //SE EXISTIR O ID, BUSCA O REGISTRO
        if ($id) {
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $usuario = ORM::factory('usuarios');
            $usuario = $usuario->where($usuario->primary_key(), "=", $this->sane($id))->find();

            $arr = array(
                "USU_ID" => $usuario->USU_ID,
                "USU_NOME" => $usuario->USU_NOME,
                "USU_EMAIL" => $usuario->USU_EMAIL,
                "USU_LOGIN" => $usuario->USU_LOGIN,
                "USU_SENHA" => "",
                "USU_DATA_CADASTRO" => $this->aaaammdd_ddmmaaaa($usuario->USU_DATA_CADASTRO),
                "PER_ID" => $usuario->PER_ID,
            );

            $view->usuario = $arr;
            
            //BUSCA A FOTO, SE HOUVER
            $foto = glob("upload/usuarios/thumb_" . $usuario->USU_ID . ".*");
            if ($foto) {
                $view->foto = "<div class='form-group'>
                        <label>Excluir Foto</label>
                        <input type='checkbox' id='excluirFoto' name='excluirFoto'>
                        <img src='" . url::base() . $foto[0] . "'>
                    </div>";
            }
            else {
                $view->foto = false;
            }
        } else {
            //SENAO, SETA COMO VAZIO
            $arr = array(
                "USU_ID" => "0",
                "USU_NOME" => "",
                "USU_EMAIL" => "",
                "USU_LOGIN" => "",
                "USU_SENHA" => "",
                "USU_DATA_CADASTRO" => date('d/m/Y'),
                "PER_ID" => "0"
            );

            $view->usuario = $arr;
            $view->foto = false;
        }

        $this->template->bt_voltar = true;

        $this->template->conteudo = $view;
    }

    //SALVA INFORMACOES
    public function action_save() {

        //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if ($this->request->post("USU_ID") == "0") {
            $usuario = ORM::factory('usuarios');

            //INSERE
            foreach ($this->request->post() as $campo => $value) {
                if($campo != "USU_SENHA_C"){
                    if($campo == "USU_SENHA"){
                        //TESTA SENHA VAZIA, NAO SALVAR
                        if($value == ""){
                            continue;
                        }else{
                            if($value == $this->request->post("USU_SENHA_C"))
                                $usuario->$campo = $value;
                        }
                    }else if ($campo == "foto" or $campo == "fotoBlob" or $campo == "fotox1" or $campo == "fotoy1" or $campo == "fotow" or $campo == "fotoh") {
                        //se for imagem não faz nada
                    }else{
                        $usuario->$campo = $value;
                    }
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $usuario->save();                
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
                    $imgName = "".$usuario->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/usuarios/".$imgName, $data);

                    //CROP
                    if($this->request->post("fotow") != "" and $this->request->post("fotow") > 0){
                        $img = Image::factory(DOCROOT."upload/usuarios/".$imgName);
                        $img = $img->crop($this->request->post("fotow"), $this->request->post("fotoh"), $this->request->post("fotox1"), $this->request->post("fotoy1"))->save(DOCROOT."upload/usuarios/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/usuarios/".$imgName);
                    $imgName = "thumb_" . $usuario->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/usuarios/".$imgName);
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors('models');
            }
        } else {
            //SENAO, UPDATE
            $usuario = ORM::factory('usuarios', $this->request->post("USU_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($usuario->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if($campo != "USU_SENHA_C"){
                        if($campo == "USU_SENHA"){
                            //TESTA SENHA VAZIA, NAO SALVAR
                            if($value == ""){
                                continue;
                            }else{
                                if($value == $this->request->post("USU_SENHA_C"))
                                    $usuario->$campo = $value;
                            }
                        }else if ($campo == "excluirFoto") {
                            $excluiFoto = str_replace("'", "", $value);
                        }else if ($campo == "foto" or $campo == "fotoBlob" or $campo == "fotox1" or $campo == "fotoy1" or $campo == "fotow" or $campo == "fotoh") {
                            //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                        }else{ 
                            $usuario->$campo = $value;
                        }
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $usuario->save();
                    
                    //SE EXCLUIR FOTO ESTIVER MARCADO, EXCLUI A FOTO
                    if($excluiFoto == "on" or $this->request->post("fotoBlob") != ""){
                        $imgsT = glob("upload/usuarios/thumb_" . $usuario->pk() . ".*");
                        $imgs = glob("upload/usuarios/" . $usuario->pk() . ".*");

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
                        $imgName = "".$usuario->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/usuarios/".$imgName, $data);

                        //CROP
                        if($this->request->post("fotow") != "" and $this->request->post("fotow") > 0){
                            $img = Image::factory(DOCROOT."upload/usuarios/".$imgName);
                            $img = $img->crop($this->request->post("fotow"), $this->request->post("fotoh"), $this->request->post("fotox1"), $this->request->post("fotoy1"))->save(DOCROOT."upload/usuarios/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/usuarios/".$imgName);
                        $imgName = "thumb_" . $usuario->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/usuarios/".$imgName);
                    }
                } catch (ORM_Validation_Exception $e){
                    $query = false;
                    $mensagem = $e->errors('models');
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
            $this->action_index("<p class='res-alert sucess'>" .$mensagem. "</p>", false);
        } else {
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>" .$mensagem. "</p>", true);
        }
    }

    //EXCLUI REGISTRO
    public function action_excluir() {
        //EXCLUI FOTO
        $imgsT = glob("upload/usuarios/thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/usuarios/" . $this->request->param("id") . ".*");

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
        $usuario = ORM::factory('usuarios', $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($usuario->loaded()){
            //DELETA
            $query = $usuario->delete();
        }else{
            $query = false;
        }

        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if ($query) {
            $this->action_index("<p class='res-alert trash'>Registro excluído com sucesso!</p>", false);
        } else {
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>Houve um problema!</p>", true);
        }
    }

    //EXCLUI TODOS REGISTROS MARCADOS
    public function action_excluirTodos() {
        $query = false;

        foreach ($this->request->post() as $value) {
            foreach ($value as $val) {
                //EXCLUI FOTO
                $imgsT = glob("upload/usuarios/thumb_" . $val . ".*");
                $imgs = glob("upload/usuarios/" . $val . ".*");

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
                $usuario = ORM::factory('usuarios', $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($usuario->loaded()){
                    //DELETA
                    $query = $usuario->delete();
                }else{
                    $query = false;
                }
            }
        }

        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if ($query) {
            $this->action_index("<p class='res-alert trash'>Registros excluídos com sucesso!</p>", false);
        } else {
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>Houve um problema! Nenhum registro selecionado!</p>", true);
        }
    }

    //FUNCAO DE PESQUISA
    public function action_pesquisa() {
        $this->action_index("", false);
    }

}

// End Usuários