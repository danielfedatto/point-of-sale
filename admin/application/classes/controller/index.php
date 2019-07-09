<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Template {

    //VIEW DEFAULT
    public $template = 'template';
    //GRAVA LOGS DE ERROS
    public $gravar_logs = TRUE;
    //NOME DA EMPRESA
    public $empresa = "Point of Sale - Admin";
    //NOME DA SESSÃO, PARA NÃO DAR BAGUNÇA COM OUTRA RESTRITAS E AFINS ABERTOS NO NAVEGADOR
    public $nomeSessao = "pointofsale";
    //DOMÍNIO
    public $dominio = "http://pointofsale.com/admin/";
    //E-MAIL DE AUTENTICAÇÃO
    public $emailEmpresa = "";
    //SENHA DO E-MAIL DE AUTENTICAÇÃO
    public $senhaEmail = "";
    //HOST DO E-MAIL DE AUTENTICAÇÃO
    public $host = "";
    //VARIÁVEL DE SESSÕES
    protected $sessao;
    //QUANTIDADE DE ITENS POR PAGINA NA LISTAGEM
    public $qtdPagina;

    public function before() {
        parent::before();

        /* TOTAL DE TABELAS: 38 */

        //SESSIONS
        $this->sessao = Session::instance();
        
       //Seta um tempo de ultimo clique para mudar o Online para offline
        setcookie("ultimoclique", time());

        //TESTA SE ESTA LOGADO
        if (!$this->sessao->get("id_usuario" . $this->nomeSessao) or !$this->sessao->get("id_permissao" . $this->nomeSessao)) {
            $this->request->redirect('login');
        }

        //TESTA O MODULO ACESSADO, SE NAO TEM PERMISSAO, REDIRECIONA PARA A HOME
        //EXCEÇÕES: CONDIÇÃO DE PAGAMENTO, GALERIA, AJAX 
        if (Request::current()->controller() != "index" and Request::current()->controller() != "galeria" and
                Request::current()->controller() != "condicaopagamento" and Request::current()->controller() != "ajax") {
            $testePermissao = ORM::factory("modulos")->with("modulospermissoes");
            $testePermissao = $testePermissao->where("MOD_LINK", "=", Request::current()->controller())
                            ->where("PER_ID", "=", $this->sessao->get("id_permissao" . $this->nomeSessao))->count_all();

            if ($testePermissao == 0) {
                $this->request->redirect("index");
            }
        }

        //CONTROLE DE ACESSOS
        $meni = Request::current()->controller();
        $acao = Request::current()->action();
        $item = Request::current()->param("id");
        $post = "";
        //SE ITEM FOR IGUAL A 0, DEVE ESTAR VINDO POR POST. ENTÃO, PEGA O PRIMEIRO ITEM QUE TEM QUE SER O ID
        if ($item == 0) {
            foreach ($this->request->post() as $idItem) {
                //SE FOR ARRAY, DEVE SER O EXCLUIRTODOS. PEGA SOH O PRIMEIRO
                if (is_array($idItem)) {
                    $item = $idItem[0];
                } else {
                    $item = $idItem;
                }
                break;
            }
        }

        if ($acao != "" and $acao != "index") {
            $acesso = ORM::factory("acessos");
            $acesso->ACE_IP = $_SERVER['REMOTE_ADDR'];
            $acesso->ACE_DATA = date("d/m/Y");
            $acesso->ACE_HORA = date("H:i:s");
            $acesso->ACE_MODULO = $meni;
            $acesso->ACE_ACAO = $acao;
            $acesso->ACE_ITEM = $item;
            $acesso->ACE_POST = $post;
            $acesso->USU_ID = $this->sessao->get('id_usuario' . $this->nomeSessao);
            $acesso->save();
        }
        //FIM CONTROLE ACESSOS

        $this->template->titulo = $this->empresa;

        //Quantidade de itens por pagina
        $this->qtdPagina = 10;

        //NOME DO VIVENTE LOGADO
        $this->template->vivente = $this->sessao->get('usuario' . $this->nomeSessao);
        
        //ID DO VIVENTE LOGADO
        $this->template->idvivente = $this->sessao->get('id_usuario' . $this->nomeSessao);

        //BUSCA AS CATEGORIAS DE MODULOS DOS MÓDULOS QUE O USUÁRIO TEM PERMISSÃO
        $this->template->categoriamodulo = ORM::factory("modulos")->with("categoriamodulo")->with("modulospermissoes")
                        ->where("PER_ID", "=", $this->sessao->get("id_permissao" . $this->nomeSessao))
                        ->group_by("CAM_ID")->order_by("CAM_ORDEM", "asc")->find_all();

        $this->template->permissao = $this->sessao->get("id_permissao" . $this->nomeSessao);
    }

    public function action_index() {
        $view = View::Factory('index');

        $permissaonoticias = ORM::factory("modulos")->with("modulospermissoes")
                                        ->where("MOD_LINK", "=", "noticias")
                                        ->where("PER_ID", "=", $this->sessao->get("id_permissao" . $this->nomeSessao))->count_all();

        if ($permissaonoticias == 0) {
            $view->noticias = false;
        }else{
            //BUSCA AS ULTIMAS NOTAS
            $view->noticias = ORM::factory("noticias")
                                            ->order_by("NOT_ID", "DESC")
                                            ->limit(5)
                                            ->find_all();
        }
        
        $this->template->bt_voltar = false;

        $this->template->conteudo = $view;
    }

    //PAGINACAO DA ORM
    public function action_page($modelo, $limit) {

        //O RESET MANTEM A QUERY PARA SER USADA NOVAMENTE NA BUSCA REAL
        $pagination = Pagination::factory(array(
                    'total_items' => $modelo->reset(false)->count_all(),
                    'items_per_page' => $limit,
                    'view' => 'pagination/floating',
                        )
        );

        // Pass controller and action names explicitly to $pagination object
        $pagination->route_params(array('controller' => $this->request->controller(), 'action' => 'index'));
        // Get data
        $data = $modelo->limit($pagination->items_per_page)->offset($pagination->offset)->find_all();
        // Pass data and validation object to view
        return array('data' => $data, 'pagination' => $pagination);
    }

    /* Fim paginacao */

    protected function mes($valor) {
        switch ($valor) {
            case "01":
                return "Janeiro";
                break;
            case "02":
                return "Fevereiro";
                break;
            case "03":
                return "Março";
                break;
            case "04":
                return "Abril";
                break;
            case "05":
                return "Maio";
                break;
            case "06":
                return "Junho";
                break;
            case "07":
                return "Julho";
                break;
            case "08":
                return "Agosto";
                break;
            case "09":
                return "Setembro";
                break;
            case "10":
                return "Outubro";
                break;
            case "11":
                return "Novembro";
                break;
            case "12":
                return "Dezembro";
                break;
        }
    }

    public static function aaaammdd_ddmmaaaa($aaaa_mm_dd) {
        $axdia = substr($aaaa_mm_dd, 8, 2);
        $axmes = substr($aaaa_mm_dd, 5, 2);
        $axano = substr($aaaa_mm_dd, 0, 4);
        $dd_mm_aaaa = $axdia . "/" . $axmes . "/" . $axano;
        return $dd_mm_aaaa;
    }

    public static function ddmmaaaa_aaaammdd($dd_mm_aaaa) {
        $axdia = substr($dd_mm_aaaa, 0, 2);
        $axmes = substr($dd_mm_aaaa, 3, 2);
        $axano = substr($dd_mm_aaaa, 6, 4);
        $aaaa_mm_dd = $axano . "-" . $axmes . "-" . $axdia;
        return $aaaa_mm_dd;
    }

    //IMPLODE DAS CHAVES DO ARRAY
    public function implode_keys($separador, $array) {
        $keys = array_keys($array);
        return implode($separador, $keys);
    }

    //FUNCAO PARA RETIRAR ACENTOS
    public static function trataTxt($var) {
        //return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($var));
        $trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ',);
        $porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U', 'Y',);
        $titletext = str_replace($trocarIsso, $porIsso, $var);
        return $titletext;
    }

    //FUNCAO PARA ARRUMAR NOMES DAS CIDADES
    public static function arrumaCidade($var) {
        //return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($var));
        $trocarIsso = array("'", "0");
        $porIsso = array("`", "O");
        $titletext = str_replace($trocarIsso, $porIsso, $var);
        return $titletext;
    }

    //FAZ SANE TEASE DOS GETS
    public static function sane($string) {
        return(str_replace(")", "", str_replace("(", "", str_replace(":", "", str_replace(";", "", preg_replace('/(\'|")/', '', $string))))));
    }
}

// End Template
