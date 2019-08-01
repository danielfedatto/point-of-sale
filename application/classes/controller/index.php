<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Template {

    //VIEW DEFAULT
    public $template = 'template';
    //GRAVA LOGS DE ERROS
    public $gravar_logs = TRUE;

    //NOME DA EMPRESA
    public $empresa = "Point of Sale";
    
    //CORES EMAIL
    public $coresEmail = array(
        'background' => '#E2E3E2', // fundo da news
        'basecolor' => '#000', // destaques e títulos
        'link' => '#003385' // links
    );
    
    //DOMÍNIO
    public $dominio = "http://localhost/point-of-sale";
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

    public $faceHeader = "";

    public function before() {
        parent::before();
        
        //SESSIONS
        $this->sessao = Session::instance();

        //CONFIGURACOES
        $configuracoes = ORM::factory("configuracoes")->where("CON_ID", "=", "1")->find();

        $this->template->titulo = $configuracoes->CON_EMPRESA;
        $this->template->keywords = $configuracoes->CON_KEYWORDS;
        $this->template->description = $configuracoes->CON_DESCRIPTION;
        $this->template->analytics = $configuracoes->CON_GOOGLE_ANALYTICS;
        $this->template->facebook = $configuracoes->CON_FACEBOOK;
        $this->template->instagram = $configuracoes->CON_INSTAGRAM;
        $this->template->pinterest = $configuracoes->CON_PINTREST;
        $this->template->behance = $configuracoes->CON_BEHANCE;
        $this->template->endereco = $configuracoes->CON_ENDERECO;
        $this->template->email = $configuracoes->CON_EMAIL;
        $this->template->telefone = $configuracoes->CON_TELEFONE;
        $this->template->atendimento = $configuracoes->CON_HORARIO_ATENDIMENTO;
        $this->template->id_logo = $configuracoes->CON_ID;

        $this->template->banners = ORM::factory("banners")
                                        ->where('BAN_INICIO', '<=', date('Y-m-d'))
                                        ->where('BAN_FIM', '>=', date('Y-m-d'));
        if(Request::current()->controller() == 'index'){
            $this->template->banners = $this->template->banners->where('BAN_PAGINA', '=', 'home');
        }else{
            $this->template->banners = $this->template->banners->where('BAN_PAGINA', '=', Request::current()->controller());
        }
        $this->template->banners = $this->template->banners->find_all();

    }

    public function action_index() {
        $view = View::Factory('index');

        $view->servicos = ORM::factory("servicos")->find_all();
        $view->cases = ORM::factory("cases")->where("CAS_HOME", "=", "S")->limit(6)->order_by(DB::expr('RAND()'))->find_all();
        $view->clientes = ORM::factory("clientes")->order_by(DB::expr('RAND()'))->find_all();
        $view->artigos = ORM::factory("artigos")->limit(3)->find_all();

        $this->template->conteudo = $view;
    }
    
    //FUNÇÃO QUE LIMITA A QUANTIDADE DE PALAVRAS EM UM TEXTO
    public static function limitar_palavras($conteudo, $quantidade) {
        $conteudo = trim(strip_tags($conteudo));
        $conteudo = explode(' ', $conteudo);
        return implode(' ', array_slice($conteudo, 0, $quantidade))." ...";
    }
    
    public static function limitarTexto($texto, $limite){
        $contador = strlen($texto);
        if ( $contador >= $limite ) {
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
            return $texto;
        }else{
            return $texto;
        }
    } 
    
    
    public static function tempoCorrido($time){

        $now = strtotime(date('Y-m-d H:i:s'));
        $time = strtotime($time);
        $diff = $now - $time;

        $seconds = $diff;
        $minutes = round($diff / 60);
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $weeks = round($diff / 604800);
        $months = round($diff / 2419200);
        $years = round($diff / 29030400);

        if ($seconds <= 60) return"1 min atrás";
        else if ($minutes <= 60) return $minutes==1 ?'1 min atrás':$minutes.' min atrás';
        else if ($hours <= 24) return $hours==1 ?'1 hrs atrás':$hours.' hrs atrás';
        else if ($days <= 7) return $days==1 ?'1 dia atras':$days.' dias atrás';
        else if ($weeks <= 4) return $weeks==1 ?'1 semana atrás':$weeks.' semanas atrás';
        else if ($months <= 12) return $months == 1 ?'1 mês atrás':$months.' meses atrás';
        else return $years == 1 ? 'um ano atrás':$years.' anos atrás';
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

    public static function MMMddaaaa($valor) {
        $data = explode('-', $valor); 
        switch ($data[1]) {
            case "01":
                $mmmddaaaa = "JAN";
                break;
            case "02":
                $mmmddaaaa = "FEV";
                break;
            case "03":
                $mmmddaaaa = "MAR";
                break;
            case "04":
                $mmmddaaaa = "ABR";
                break;
            case "05":
                $mmmddaaaa = "MAI";
                break;
            case "06":
                $mmmddaaaa = "JUN";
                break;
            case "07":
                $mmmddaaaa = "JUL";
                break;
            case "08":
                $mmmddaaaa = "AGO";
                break;
            case "09":
                $mmmddaaaa = "SET";
                break;
            case "10":
                $mmmddaaaa = "OUT";
                break;
            case "11":
                $mmmddaaaa = "NOV";
                break;
            case "12":
                $mmmddaaaa = "DEZ";
                break;
        }
        return $mmmddaaaa .= ' '.$data[2].', '.$data[0];
    }
    
    public static function dataextenso($data) {
        $data = explode("-", $data);
        $data = $data[2]." de ".strtolower(Controller_Index::mes($data[1]))." de ".$data[0];
        return $data;
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
    
    //FUNÇÃO QUE ARRUMA TITULOS PARA URL
    public static function arrumaURL($txt) {
        $txt = str_replace("?", "", $txt);
        $txt = str_replace(",", "", $txt);
        $txt = str_replace(";", "", $txt);
        $txt = str_replace("&", "", $txt);
        $txt = str_replace("/", "", $txt);
        $txt = str_replace(".", "", $txt);
        $txt = str_replace("(", "", $txt);
        $txt = str_replace(")", "", $txt);
        $txt = str_replace("%", "", $txt);
        return str_replace("+", "-", urlencode(trim(strip_tags($txt))));
    }

    //FAZ SANE TEASE DOS GETS
    public static function sane($string) {
        return(str_replace(")", "", str_replace("(", "", str_replace(":", "", str_replace(";", "", preg_replace('/(\'|")/', '', $string))))));
    }
}

// End Template
