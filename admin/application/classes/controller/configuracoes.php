<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Configuracoes extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Configurações";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("configuracoes/list");
        
        $ordem = "CON_ID";
        $sentido = "desc";

        //BUSCA OS REGISTROS        
        $configuracoes = ORM::factory("configuracoes");
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $configuracoes->setColumns(array("CON_ID"=>"CON_ID", "CON_EMPRESA"=>"CON_EMPRESA"));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $configuracoes = $configuracoes->where("CON_EMPRESA", "like", "%".$this->sane($_GET["chave"])."%");
        }
        
        /* ORDENAÇÃO */
        if (isset($_GET["ordem"])) {
            if ($_GET["ordem"] != "") {
                $configuracoes->order_by($this->sane($_GET["ordem"]), $this->sane($_GET["sentido"]));
                $ordem = $this->sane($_GET["ordem"]);
                $sentido = $this->sane($_GET["sentido"]);
            }
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($configuracoes, $this->qtdPagina);
        $view->configuracoes = $paginas["data"];
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
        $view = View::Factory("configuracoes/edit");
        
        $id = $this->request->param("id");
        
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $configuracoes = ORM::factory("configuracoes");
            $configuracoes = $configuracoes->where($configuracoes->primary_key(), "=", $this->sane($id))->find();
            
            $arr = array(
                "CON_ID" => $configuracoes->CON_ID,
                "CON_EMPRESA" => $configuracoes->CON_EMPRESA,
                "CON_KEYWORDS" => $configuracoes->CON_KEYWORDS,
                "CON_DESCRIPTION" => $configuracoes->CON_DESCRIPTION,
                "CON_GOOGLE_ANALYTICS" => $configuracoes->CON_GOOGLE_ANALYTICS,
                "CON_FACEBOOK" => $configuracoes->CON_FACEBOOK,
                "CON_INSTAGRAM" => $configuracoes->CON_INSTAGRAM,
                "CON_PINTREST" => $configuracoes->CON_PINTREST,
                "CON_BEHANCE" => $configuracoes->CON_BEHANCE,
                "CON_ENDERECO" => $configuracoes->CON_ENDERECO,
                "CON_EMAIL" => $configuracoes->CON_EMAIL,
                "CON_TELEFONE" => $configuracoes->CON_TELEFONE,
                "CON_HORARIO_ATENDIMENTO" => $configuracoes->CON_HORARIO_ATENDIMENTO,
            );
            
            $view->configuracoes = $arr;
                    
            //BUSCA O LOGO, SE HOUVER
            $logo = glob("upload/configuracoes/logo_" . $configuracoes->CON_ID . ".*");
            if ($logo) {
                $view->logo = "<div class='form-group'>
                        <label class='col-sm-2 control-label'>Excluir Logo</label>
                        <input type='checkbox' id='excluirLogo' name='excluirLogo'>
                        Arquivo Cadastrado!!
                    </div>";
            }
            else {
                $view->logo = false;
            }
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "CON_ID" => "0",
                "CON_EMPRESA" => "",
                "CON_KEYWORDS" => "",
                "CON_DESCRIPTION" => "",
                "CON_GOOGLE_ANALYTICS" => "",
                "CON_FACEBOOK" => "",
                "CON_INSTAGRAM" => "",
                "CON_PINTREST" => "",
                "CON_BEHANCE" => "",
                "CON_ENDERECO" => "",
                "COM_EMAIL" => "",
                "CON_TELEFONE" => "",
                "CON_HORARIO_ATENDIMENTO" => "",
            );
            
            $view->configuracoes = $arr;
            $view->logo = false;
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){ //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";

        $excluiLogo = false;
                
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("CON_ID") == "0" ){ 
            
            $configuracoes = ORM::factory("configuracoes");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $configuracoes->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $configuracoes->save();
                $mensagem = "Registro inserido com sucesso!";
                            
                //INSERE O ARQUIVO, SE EXISTIR
                if ($_FILES["logo"]["name"] != "") {

                    $ext = explode(".", $_FILES["logo"]["name"]);
                    $arqName = "logo_".$configuracoes->pk() . "." . $ext[count($ext) - 1];

                    if($ext[count($ext) - 1] == "doc" or $ext[count($ext) - 1] == "docx" or $ext[count($ext) - 1] == "pdf"){
                        copy($_FILES["logo"]["tmp_name"], DOCROOT."upload/configuracoes/".$arqName);
                    }
                }
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }
        }else{
            //SENAO, UPDATE
            $configuracoes = ORM::factory("configuracoes", $this->request->post("CON_ID"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($configuracoes->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){
                    if ($campo == "excluirLogo") {
                        $excluiLogo = str_replace("'", "", $value);
                    }else{ 
                        $configuracoes->$campo = $value;
                    }
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $configuracoes->save();
                    //SE EXCLUIR LOGO ESTIVER MARCADO, EXCLUI O LOGO
                    if($excluiLogo == "on" or $_FILES["logo"]["name"] != ""){
                        $arq = glob("upload/configuracoes/logo_" . str_replace("'", "", $configuracoes->pk()) . ".*");

                        if($arq){
                            foreach($arq as $ar){
                                unlink($ar);
                            }
                        }
                    }

                    //INSERE O LOGO, SE EXISTIR
                    if ($_FILES["logo"]["name"] != "") {

                        $ext = explode(".", $_FILES["logo"]["name"]);
                        $arqName = "logo_".str_replace("'", "", $configuracoes->pk()) . "." . $ext[count($ext) - 1];

                        if($ext[count($ext) - 1] == "doc" or $ext[count($ext) - 1] == "docx" or $ext[count($ext) - 1] == "pdf"){
                            copy($_FILES["logo"]["tmp_name"], DOCROOT."upload/configuracoes/".$arqName);
                        }
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
        if($query or $_FILES["logo"]["name"] != "" or $excluiLogo){
            $this->action_index("<p class='res-alert sucess'>".$mensagem."</p>", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("<p class='res-alert warning'>".$mensagem."</p>", true);
        }}
    
    //EXCLUI REGISTRO
    public function action_excluir(){
        //EXCLUI LOGO
        $arq = glob("upload/configuracoes/logo_" . $this->request->param("id") . ".*");

        if($arq){
            foreach($arq as $ar){
                unlink($ar);
            }
        }
        $configuracoes = ORM::factory("configuracoes", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($configuracoes->loaded()){
            //DELETA
            $query = $configuracoes->delete();
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
                //EXCLUI LOGO
                $arq = glob("upload/configuracoes/logo_" . $val . ".*");

                if($arq){
                    foreach($arq as $ar){
                        unlink($ar);
                    }
                }
                $configuracoes = ORM::factory("configuracoes", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($configuracoes->loaded()){
                    //DELETA
                    $query = $configuracoes->delete();
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

// End Configurações
