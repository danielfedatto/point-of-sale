<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Permissoes extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - PERMISSÕES";

        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {
        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory('permissoes/list');

        //BUSCA OS REGISTROS        
        $permissoes = ORM::factory('permissoes');
        
        //SETA AS COLUNAS QUE VAI BUSCAR
        $permissoes->setColumns(array("PER_ID"=>"PER_ID", "PER_NOME"=>"PER_NOME"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $permissoes = $permissoes->where("PER_NOME", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($permissoes, $this->qtdPagina);
        $view->permissoes = $paginas["data"];
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
        $view = View::Factory('permissoes/edit');

        $id = $this->request->param("id");

        $view->modulos = ORM::factory("modulos")->find_all();

        //SE EXISTIR O ID, BUSCA O REGISTRO
        if ($id) {
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $permissao = ORM::factory('permissoes');
            $permissao = $permissao->where($permissao->primary_key(), "=", $this->sane($id))->find();

            $arr = array(
                "PER_ID" => $permissao->PER_ID,
                "PER_NOME" => $permissao->PER_NOME
            );

            //BUSCA OS MODULOS CADASTRADOS E PREENCHE OS CAMPOS
            $permissoesP = ORM::factory("modulospermissoes")->where("PER_ID", "=", $id)->find_all();

            //SE HOUVER RESULTADOS, PREENCHE. SENÃO, DEIXA VAZIO
            if (count($permissoesP) > 0) {
                foreach ($permissoesP as $mop) {
                    $mods[$mop->MOD_ID] = $mop->modulos->MOD_NOME;
                }
            } else {
                $mods = false;
            }

            $view->permissao = $arr;
            $view->mods = $mods;
        } else {
            //SENAO, SETA COMO VAZIO
            $arr = array(
                "PER_ID" => "0",
                "PER_NOME" => ""
            );

            $mods = false;

            $view->permissao = $arr;
            $view->mods = $mods;
        }

        $this->template->bt_voltar = true;

        $this->template->conteudo = $view;
    }

    //SALVA INFORMACOES
    public function action_save() {
        
        //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if ($this->request->post("PER_ID") == "0") {
            $permissao = ORM::factory('permissoes');
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                //SE NAO FOR OS MODULOS. SENAO, BUSCA O ARRAY DE MODULOS E MONTA
                if (substr($campo, 0, 3) != "MOD") {
                    $permissao->$campo = $value;
                } else {
                    foreach ($value as $val) {
                        $modulos[] = $val;
                    }
                }
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $permissao->save();
                
                //INSERE OS MODULOS PASSADOS POR PARAMETRO
                if (isset($modulos)) {
                    foreach ($modulos as $mod) {
                        $modulopermissao = ORM::factory("modulospermissoes");
                        $modulopermissao->MOD_ID = $mod;
                        $modulopermissao->PER_ID = $permissao->pk();
                        $modulopermissao->save();
                    }
                }
                
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors('models');
            }
        }else {
            //SENAO, UPDATE
            $permissao = ORM::factory('permissoes', $this->request->post("PER_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($permissao->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    //SE NAO FOR OS MODULOS. SENAO, BUSCA O ARRAY DE MODULOS E MONTA
                    if (substr($campo, 0, 3) != "MOD") {
                        $permissao->$campo = $value;
                    } else {
                        foreach ($value as $val) {
                            $modulos[] = $val;
                        }
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $permissao->save();
                    
                    //RETIRA OS MODULOS DA PERMISSÃO
                    $modulopermissao = ORM::factory("modulospermissoes")->where("PER_ID", "=", $permissao->pk())->find_all();
                    //print_r($modulopermissao); exit;
                    foreach($modulopermissao as $mop){
                        $mop->delete();
                    }

                    //INSERE OS MODULOS PASSADOS POR PARAMETRO
                    if (isset($modulos)) {
                        foreach ($modulos as $mod) {
                            $modulopermissao = ORM::factory("modulospermissoes");
                            $modulopermissao->MOD_ID = $mod;
                            $modulopermissao->PER_ID = $permissao->pk();
                            $modulopermissao->save();
                        }
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
        if ($query) {
            $this->action_index("<p class='res-alert sucess'>" .$mensagem. "</p>", false);
        } else {
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>" .$mensagem. "</p>", true);
        }
    }

    //EXCLUI REGISTRO
    public function action_excluir() {
        //VERIFICA SE EXISTEM USUARIOS NESSA PERMISSAO. SE EXISTIR, NÃO DEIXA EXCLUIR
        $usuarios = ORM::factory("usuarios")->where("PER_ID", "=", $this->request->param("id"))->count_all();

        if ($usuarios > 0) {
            $this->action_index("<p class='res-alert warning'>Existem usuários cadastrados nessa permissão! Nenhuma alteração realizada!</p>", true);
        } else {
            $permissao = ORM::factory('permissoes', $this->request->param("id"));
            
            //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
            if ($permissao->loaded()){
                //DELETA
                $query = $permissao->delete();
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
    }

    //EXCLUI TODOS REGISTROS MARCADOS
    public function action_excluirTodos() {
        $query = false;

        foreach ($this->request->post() as $value) {
            foreach ($value as $val) {
                //VERIFICA SE EXISTEM USUARIOS NESSA PERMISSAO. SE EXISTIR, NÃO DEIXA EXCLUIR
                $usuarios = ORM::factory("usuarios")->where("USU_ID", "=", $val)->count_all();

                if ($usuarios > 0) {
                    $this->action_index("<p class='res-alert warning'>Existem usuários cadastrados nessa permissão! Nenhuma alteração realizada!</p>", true);
                    return true;
                } else {
                    $permissao = ORM::factory('permissoes', $val);
            
                    //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                    if ($permissao->loaded()){
                        //DELETA
                        $query = $permissao->delete();
                    }else{
                        $query = false;
                    }
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

// End Permissões