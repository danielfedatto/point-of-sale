<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Contatos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Contatos";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("contatos/list");
        
        $ordem = "CON_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $contatos = ORM::factory("contatos");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $contatos->setColumns(array("CON_ID"=>"CON_ID", "CON_DATA"=>"CON_DATA", "CON_NOME"=>"CON_NOME", "CON_EMAIL"=>"CON_EMAIL", "CON_FONE"=>"CON_FONE"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $contatos = $contatos->where("CON_DATA", "like", "%".$this->sane($this->ddmmaaaa_aaaammdd(addslashes($_GET["chave"])))."%")->or_where("CON_NOME", "like", "%".$this->sane($_GET["chave"])."%")->or_where("CON_EMAIL", "like", "%".$this->sane($_GET["chave"])."%")->or_where("CON_FONE", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $contatos->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($contatos, $this->qtdPagina);
        $view->contatos = $paginas["data"];
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
        $view = View::Factory("contatos/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $contatos = ORM::factory("contatos");
            $contatos = $contatos->where($contatos->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CON_ID" => $contatos->CON_ID,
                "CON_DATA" => $contatos->CON_DATA,
                "CON_NOME" => $contatos->CON_NOME,
                "CON_EMAIL" => $contatos->CON_EMAIL,
                "CON_FONE" => $contatos->CON_FONE,
                "CON_MENSAGEM" => $contatos->CON_MENSAGEM,
            );
            
            $view->contatos = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CON_ID" => "0",
                "CON_DATA" => date("Y-m-d"),
                "CON_NOME" => "",
                "CON_EMAIL" => "",
                "CON_FONE" => "",
                "CON_MENSAGEM" => "",
            );
            
            $view->contatos = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CON_ID") == "0" ){ 
            
            $contatos = ORM::factory("contatos");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $contatos->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $contatos->save();
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $contatos = ORM::factory("contatos", $this->request->post("CON_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($contatos->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $contatos->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $contatos->save();
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
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End Contatos
