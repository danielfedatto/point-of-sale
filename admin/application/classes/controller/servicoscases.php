<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Servicoscases extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Servicos Cases";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("servicoscases/list");
        
        $ordem = "SEC_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $servicoscases = ORM::factory("servicoscases")->with("cases")->with("servicos");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $servicoscases->setColumns(array("SEC_ID"=>"SEC_ID"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $servicoscases = $servicoscases;
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $servicoscases->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($servicoscases, $this->qtdPagina);
        $view->servicoscases = $paginas["data"];
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
        $view = View::Factory("servicoscases/edit");
        
        $id = $this->request->param("id");
        
        //BUSCA CASES
        $view->cases = ORM::factory("cases")->find_all();
                            
        //BUSCA SERVICOS
        $view->servicos = ORM::factory("servicos")->find_all();
                            
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $servicoscases = ORM::factory("servicoscases");
            $servicoscases = $servicoscases->where($servicoscases->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "SEC_ID" => $servicoscases->SEC_ID,
                "CAS_ID" => $servicoscases->CAS_ID,
                "SER_ID" => $servicoscases->SER_ID,
            );
            
            $view->servicoscases = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "SEC_ID" => "0",
                "CAS_ID" => "",
                "SER_ID" => "",
            );
            
            $view->servicoscases = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("SEC_ID") == "0" ){ 
            
            $servicoscases = ORM::factory("servicoscases");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $servicoscases->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $servicoscases->save();
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $servicoscases = ORM::factory("servicoscases", $this->request->post("SEC_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($servicoscases->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $servicoscases->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $servicoscases->save();
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
        $servicoscases = ORM::factory("servicoscases", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($servicoscases->loaded()){
            //DELETA
            $query = $servicoscases->delete();
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
                $servicoscases = ORM::factory("servicoscases", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($servicoscases->loaded()){
                    //DELETA
                    $query = $servicoscases->delete();
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

// End Servicos Cases
