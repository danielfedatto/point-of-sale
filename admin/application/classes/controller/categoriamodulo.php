<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Categoriamodulo extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Categoria Módulo";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("categoriamodulo/list");
        
        //BUSCA OS REGISTROS        
        $categoriamodulo = ORM::factory("categoriamodulo");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $categoriamodulo->setColumns(array("CAM_ID"=>"CAM_ID", "CAM_NOME"=>"CAM_NOME", "CAM_ORDEM"=>"CAM_ORDEM"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $categoriamodulo = $categoriamodulo->where("CAM_NOME", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($categoriamodulo, $this->qtdPagina);
        $view->categoriamodulo = $paginas["data"];
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
        $view = View::Factory("categoriamodulo/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $categoriamodulo = ORM::factory("categoriamodulo");
            $categoriamodulo = $categoriamodulo->where($categoriamodulo->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CAM_ID" => $categoriamodulo->CAM_ID,
                "CAM_NOME" => $categoriamodulo->CAM_NOME,
                "CAM_ORDEM" => $categoriamodulo->CAM_ORDEM,
            );
            
            $view->categoriamodulo = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CAM_ID" => "0",
                "CAM_NOME" => "",
                "CAM_ORDEM" => "",
            );
            
            $view->categoriamodulo = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){

        //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CAM_ID") == "0" ){ 
            
            $categoriamodulo = ORM::factory("categoriamodulo");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $categoriamodulo->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $categoriamodulo->save();
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $categoriamodulo = ORM::factory("categoriamodulo", $this->request->post("CAM_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($categoriamodulo->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $categoriamodulo->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $categoriamodulo->save();
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
        if($query){
            $this->action_index("<p class='res-alert sucess'>" .$mensagem. "</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>" .$mensagem. "</p>", true);
        }
    }
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //VERIFICA SE EXISTEM MODULOS NESSA CATEGORIA MODULO. SE EXISTIR, NÃO DEIXA EXCLUIR
        $modulos = ORM::factory("modulos")->where("CAM_ID", "=", $this->request->param("id"))->count_all();
                        
        if ($modulos > 0){
            $this->action_index("<p class='res-alert warning'>Existem Módulos cadastrados nessa Categoria Módulo! Nenhuma alteração realizada!</p>", true);
        }else{
                        
        $categoriamodulo = ORM::factory("categoriamodulo", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($categoriamodulo->loaded()){
            //DELETA
            $query = $categoriamodulo->delete();
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
    public function action_excluirTodos() {
        $query = false;
        
        foreach ($this->request->post() as $value) {
            foreach($value as $val){
                //VERIFICA SE EXISTEM MODULOS NESSA CATEGORIA MODULO. SE EXISTIR, NÃO DEIXA EXCLUIR
                $modulos = ORM::factory("modulos")->where("CAM_ID", "=", $this->request->param("id"))->count_all();
                        
                if ($modulos > 0){
                    $this->action_index("<p class='res-alert warning'>Existem Módulos cadastrados nessa Categoria Módulo! Nenhuma alteração realizada!</p>", true);
                    return true;
                }else{
                        
                $categoriamodulo = ORM::factory("categoriamodulo", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($categoriamodulo->loaded()){
                    //DELETA
                    $query = $categoriamodulo->delete();
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
        }
    }
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End Categoria Módulo
