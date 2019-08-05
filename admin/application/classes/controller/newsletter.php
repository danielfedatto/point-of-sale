<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Newsletter extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Newsletter";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("newsletter/list");
        
        $ordem = "NEW_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $newsletter = ORM::factory("newsletter");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $newsletter->setColumns(array("NEW_ID"=>"NEW_ID", "NEW_EMAIL"=>"NEW_EMAIL"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $newsletter = $newsletter->where("NEW_EMAIL", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $newsletter->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($newsletter, $this->qtdPagina);
        $view->newsletter = $paginas["data"];
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
        $view = View::Factory("newsletter/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $newsletter = ORM::factory("newsletter");
            $newsletter = $newsletter->where($newsletter->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "NEW_ID" => $newsletter->NEW_ID,
                "NEW_EMAIL" => $newsletter->NEW_EMAIL,
            );
            
            $view->newsletter = $arr;
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "NEW_ID" => "0",
                "NEW_EMAIL" => "",
            );
            
            $view->newsletter = $arr;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("NEW_ID") == "0" ){ 
            
            $newsletter = ORM::factory("newsletter");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $newsletter->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $newsletter->save();
                $mensagem = "Registro inserido com sucesso!";
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $newsletter = ORM::factory("newsletter", $this->request->post("NEW_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($newsletter->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    $newsletter->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $newsletter->save();
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
        $newsletter = ORM::factory("newsletter", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($newsletter->loaded()){
            //DELETA
            $query = $newsletter->delete();
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
                $newsletter = ORM::factory("newsletter", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($newsletter->loaded()){
                    //DELETA
                    $query = $newsletter->delete();
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
    
    public function action_excel() {
        $this->auto_render = FALSE;
        
        $arquivo = 'newsletter_'.date('d_m_Y').'.xls';   

        $newsletter = ORM::factory('newsletter')->find_all();
                
        $html = "";
        $html .= "<table border='1'>";
            $html .= "<tr>";
                $html .= "<td colspan='2' align='center'><b>NEWSLETTER</b></td>";
            $html .= "</tr>";
        foreach ($newsletter as $news){
            $html .= "<tr>";
                $html .= "<td>".$news->NEW_ID."</td>";
                $html .= "<td>".$news->NEW_EMAIL."</td>";
            $html .= "</tr>";
        }
        
        $html .='</table>';
        
        // Configurações header para forçar o download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$arquivo.'"');
        header('Cache-Control: max-age=0');
        // Se for o IE9, isso talvez seja necessário
        header('Cache-Control: max-age=1');
        
        // Envia o conteúdo do arquivo
        echo utf8_decode($html);
        
        $this->action_index("", false);
    }
        
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End Newsletter
