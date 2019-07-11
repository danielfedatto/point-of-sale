<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Nos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Nós";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("nos/list");
        
        $ordem = "NOS_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $nos = ORM::factory("nos");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $nos->setColumns(array("NOS_ID"=>"NOS_ID", "NOS_TITULO"=>"NOS_TITULO"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $nos = $nos->where("NOS_TITULO", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $nos->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($nos, $this->qtdPagina);
        $view->nos = $paginas["data"];
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
        $view = View::Factory("nos/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $nos = ORM::factory("nos");
            $nos = $nos->where($nos->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "NOS_ID" => $nos->NOS_ID,
                "NOS_TITULO" => $nos->NOS_TITULO,
                "NOS_TEXTO" => $nos->NOS_TEXTO,
            );
            
            $view->nos = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "NOS_ID" => "0",
                "NOS_TITULO" => "",
                "NOS_TEXTO" => "",
            );
            
            $view->nos = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("NOS_ID") == "0" ){ 
            
            $nos = ORM::factory("nos");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $nos->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $nos->save();
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $nos = ORM::factory("nos", $this->request->post("NOS_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($nos->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $nos->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $nos->save();
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
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){/* NÃO EXCLUI
        $nos = ORM::factory("nos", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($nos->loaded()){
            //DELETA
            $query = $nos->delete();
        }else{
            $query = false;
        }
        
        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if($query){
            $this->action_index("<p class='res-alert trash'>Registro excluído com sucesso!</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>Houve um problema!</p>", true);
        }*/ $this->request->redirect("nos");
    }
    
    //EXCLUI TODOS REGISTROS MARCADOS
    public function action_excluirTodos() {/* NÃO EXCLUI$query = false;
        
        foreach ($this->request->post() as $value) {
            foreach($value as $val){
                $nos = ORM::factory("nos", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($nos->loaded()){
                    //DELETA
                    $query = $nos->delete();
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
        }*/ $this->request->redirect("nos");}
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End Nós
