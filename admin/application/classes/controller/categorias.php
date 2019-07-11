<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Categorias extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Categorias";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("categorias/list");
        
        $ordem = "CAT_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $categorias = ORM::factory("categorias");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $categorias->setColumns(array("CAT_ID"=>"CAT_ID", "CAT_TITULO"=>"CAT_TITULO"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $categorias = $categorias->where("CAT_TITULO", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $categorias->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($categorias, $this->qtdPagina);
        $view->categorias = $paginas["data"];
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
        $view = View::Factory("categorias/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $categorias = ORM::factory("categorias");
            $categorias = $categorias->where($categorias->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CAT_ID" => $categorias->CAT_ID,
                "CAT_TITULO" => $categorias->CAT_TITULO,
            );
            
            $view->categorias = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CAT_ID" => "0",
                "CAT_TITULO" => "",
            );
            
            $view->categorias = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CAT_ID") == "0" ){ 
            
            $categorias = ORM::factory("categorias");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $categorias->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $categorias->save();
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $categorias = ORM::factory("categorias", $this->request->post("CAT_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($categorias->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $categorias->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $categorias->save();
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
    public function action_excluir(){
        //VERIFICA SE EXISTEM BLOGCATEGORIAS NESSA CATEGORIAS. SE EXISTIR, NÃO DEIXA EXCLUIR
        $blogcategorias = ORM::factory("blogcategorias")->where("CAT_ID", "=", $this->request->param("id"))->count_all();
                        
        if ($blogcategorias > 0){
            $this->action_index("<p class='res-alert warning'>Existem Blog Categorias cadastrados nessa Categorias! Nenhuma alteração realizada!</p>", true);
        }else{
                        
        $categorias = ORM::factory("categorias", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($categorias->loaded()){
            //DELETA
            $query = $categorias->delete();
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
                //VERIFICA SE EXISTEM BLOGCATEGORIAS NESSA CATEGORIAS. SE EXISTIR, NÃO DEIXA EXCLUIR
                $blogcategorias = ORM::factory("blogcategorias")->where("CAT_ID", "=", $this->request->param("id"))->count_all();
                        
                if ($blogcategorias > 0){
                    $this->action_index("<p class='res-alert warning'>Existem Blog Categorias cadastrados nessa Categorias! Nenhuma alteração realizada!</p>", true);
                    return true;
                }else{
                        
                $categorias = ORM::factory("categorias", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($categorias->loaded()){
                    //DELETA
                    $query = $categorias->delete();
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

// End Categorias
