<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Modulos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - MODULOS";
                
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }
    
    public function action_index($mensagem = "", $erro = false) {
        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory('modulos/list');
                
        //BUSCA OS REGISTROS        
        $modulos = ORM::factory('modulos');
        
        //SETA AS COLUNAS QUE VAI BUSCAR
        $modulos->setColumns(array("MOD_ID"=>"MOD_ID", "MOD_NOME"=>"MOD_NOME", "MOD_LINK"=>"MOD_LINK"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $modulos = $modulos->where("MOD_NOME", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($modulos, $this->qtdPagina);
        $view->modulos = $paginas["data"];
        $view->pagination = $paginas["pagination"];
        
        //PASSA A MENSAGEM
        $view->mensagem = $mensagem;
        $view->erro = $erro;
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //FORMULARIO DE CADASTRO
    public function action_edit(){
        //INSTANCIA A VIEW DE EDICAO
        $view = View::Factory('modulos/edit');
        
        $id = $this->request->param("id");
        
        //BUSCA AS CATEGORIAS
        $view->categoriamodulo = ORM::factory("categoriamodulo")->find_all();
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $modulo = ORM::factory('modulos');
            $modulo = $modulo->where($modulo->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "MOD_ID" => $modulo->MOD_ID,
                "MOD_NOME" => $modulo->MOD_NOME,
                "MOD_LINK" => $modulo->MOD_LINK,
                "MOD_ICONE" => $modulo->MOD_ICONE,
                "CAM_ID" => $modulo->CAM_ID
            );
            
            $view->modulo = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array(
                "MOD_ID" => "0",
                "MOD_NOME" => "",
                "MOD_LINK" => "",
                "MOD_ICONE" => "livro",
                "CAM_ID" => ""
            );
            
            $view->modulo = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){
        
        //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";
        
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("MOD_ID") == "0"){
            
            $modulo = ORM::factory('modulos');
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $modulo->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $modulo->save();
                
                //INSERE PERMISSAO MASTER NESSE MODULO
                $permissaoMaster = ORM::factory("modulospermissoes");
                $permissaoMaster->PER_ID = 1;
                $permissaoMaster->MOD_ID = $modulo->pk();
                $permissaoMaster->save();
                
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors('models');
            }
        }else{
            //SENAO, UPDATE
            $modulo = ORM::factory('modulos', $this->request->post("MOD_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($modulo->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $modulo->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $modulo->save();
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
        if($query){
            $this->action_index("<p class='res-alert sucess'>" .$mensagem. "</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>" .$mensagem. "</p>", true);
        }
    }
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        $modulo = ORM::factory('modulos', $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($modulo->loaded()){
            //DELETA
            $query = $modulo->delete();
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
    public function action_excluirTodos() {
        $query = false;
        
        foreach ($this->request->post() as $value) {
            foreach($value as $val){
                $modulo = ORM::factory('modulos', $val);
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($modulo->loaded()){
                    //DELETA
                    $query = $modulo->delete();
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
        }
    }
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }
}

// End Módulos