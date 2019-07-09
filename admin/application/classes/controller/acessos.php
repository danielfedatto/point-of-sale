<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Acessos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Acessos";

        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {
        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory('acessos/list');

        //BUSCA OS USUARIOS
        $view->usuariosfiltro = ORM::factory('usuarios')->find_all();
        
        //INICIA OS FILTROS EXCEL
        $view->usuario = "";
        $view->inicio = "";
        $view->fim = "";
        $view->modulo = "";
        
        //BUSCA OS REGISTROS        
        $acessos = ORM::factory('acessos');

        //TESTA SE TEM PESQUISA
        if (isset($_GET["usuario"])) {
            if($_GET["usuario"] != ""){
                $acessos = $acessos->where("USU_ID", "=", $_GET["usuario"]);
                $view->usuario = $_GET["usuario"];
            }
        }
        if (isset($_GET["inicio"])) {
            if($_GET["inicio"] != ""){
                $acessos = $acessos->where("ACE_DATA", ">=", Controller_Index::ddmmaaaa_aaaammdd($_GET["inicio"]));
                $view->inicio = Controller_Index::ddmmaaaa_aaaammdd($_GET["inicio"]);
            }
        }
        if (isset($_GET["fim"])) {
            if($_GET["fim"] != ""){
               $acessos = $acessos->where("ACE_DATA", "<=", Controller_Index::ddmmaaaa_aaaammdd($_GET["fim"]));
               $view->fim = Controller_Index::ddmmaaaa_aaaammdd($_GET["fim"]);
            }
        }
        if (isset($_GET["modulo"])) {
            if($_GET["modulo"] != ""){
               $acessos = $acessos->where("ACE_MODULO", "like", "%".$this->sane($_GET["modulo"])."%");
               $view->modulo = $_GET["modulo"];
            }
        }

        //PAGINAÇÃO
        $paginas = $this->action_page($acessos, 50);
        $view->acessos = $paginas["data"];
        $view->pagination = $paginas["pagination"];

        //PASSA A MENSAGEM
        $view->mensagem = $mensagem;
        $view->erro = $erro;

        $this->template->bt_voltar = true;

        $this->template->conteudo = $view;
    }

    //FUNCAO DE PESQUISA
    public function action_pesquisa() {
        $this->action_index("", false);
    }
    
    public function action_excel() {
        $this->auto_render = FALSE;
        $post = $this->request->post();
        
        $arquivo = 'acessos_'.date('d_m_Y').'.xls';
        
        //BUSCA OS REGISTROS        
        $acessos = ORM::factory('acessos');

        //TESTA SE TEM PESQUISA
        if($post["usuario"] != ""){
            $acessos = $acessos->where("USU_ID", "=", $post["usuario"]);
        }

        if($post["inicio"] != ""){
            $acessos = $acessos->where("ACE_DATA", ">=", $post["inicio"]);
        }

        if($post["fim"] != ""){
           $acessos = $acessos->where("ACE_DATA", "<=", $post["fim"]);
        }

        if($post["modulo"] != ""){
           $acessos = $acessos->where("ACE_MODULO", "like", "%".$this->sane($post["modulo"])."%");
        }
        
        $acessos = $acessos->find_all();
        
        $html = "";
        $html .= "<table>";
            $html .= "<tr>";
                $html .= "<td><b>#</b></td>";
                $html .= "<td><b>Usuário</b></td>";
                $html .= "<td><b>IP</b></td>";
                $html .= "<td><b>Data</b></td>";
                $html .= "<td><b>Hora</b></td>";
                $html .= "<td><b>Módulo</b></td>";
                $html .= "<td><b>Ação</b></td>";
                $html .= "<td><b>Item</b></td>";
            $html .= "</tr>";
        foreach ($acessos as $ac){
            $html .= "<tr>";
                $html .= "<td>".$ac->ACE_ID."</td>";
                $html .= "<td>".$ac->usuarios->USU_NOME."</td>";
                $html .= "<td>".$ac->ACE_IP."</td>";
                $html .= "<td>".Controller_Index::aaaammdd_ddmmaaaa($ac->ACE_DATA)."</td>";
                $html .= "<td>".$ac->ACE_HORA."</td>";
                $html .= "<td>".$ac->ACE_MODULO."</td>";
                $html .= "<td>".$ac->ACE_ACAO."</td>";
                $html .= "<td>".$ac->ACE_ITEM."</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        
        
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

}

// End Usuários