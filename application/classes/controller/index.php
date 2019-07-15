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
        $this->template->id_logo = $configuracoes->CON_ID;
    }

    public function action_index() {
        $view = View::Factory('index');

        $view->servicos = ORM::factory("servicos")->find_all();
        $view->clientes = ORM::factory("clientes")->order_by(DB::expr('RAND()'))->find_all();

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
    
    
    public function action_contatos() {
        $this->auto_render = FALSE;
        
        $empresa = "Business Connection";
        if ($this->request->is_ajax()) {

            $contato = ORM::factory("contatos");
            
            //INSERE
            foreach($this->request->post() as $campo => $value){
                $contato->$campo = $value;
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $contato->CON_DATA = date("d/m/Y");
                $query = $contato->save();

                $depa = "atendimento@businessconnection2019.com.br";
                
                //TEXTO INTERNO
                $texto = '';

                //MONTA O TEXTO
                foreach($this->request->post() as $campo => $value){
                    $label = str_replace("CON_", "", $campo);
                    $valor = $value;
                    if($campo == "CON_MENSAGEM"){
                        $valor = nl2br($value);
                    }
                    $texto .= '<p style="line-height:1.6em;margin:10px 0;">'.ucwords(strtolower($label)).': ' . $valor . ' </p>';
                }

                //TEXTO EMAIL
                $msg = '<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="background-color:#ebebeb;font-family:sans-serif;" width="100%">
                            <tr>
                                    <td height="20px"></td>
                            </tr>
                            <tr>
                                <td>
                                <table cellpadding="0" cellspacing="0" border="0" align="center" width="700" style="background-color:' . $this->coresEmail['background'] . ';border-radius:35px;">
                                    <tr>
                                        <td style="padding:15px;text-align:center;">
                                            <img src="' . $this->dominio . 'images/logo-fixed.png" width="260" style="vertical-align:middle;"/>
                                            <span style="color:' . $this->coresEmail['basecolor'] . ';margin-left:150px;font-weight:bold;font-size:20px;">Contato</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px;">
                                            <div style="background-color:#fff;margin:auto;padding:15px;width:660px;border-radius:10px;">
                                                <h1 style="color:' . $this->coresEmail['basecolor'] . ';margin-top:0;margin-bottom: 15px;">Contato</h1>
                                                <p style="line-height:1.6em;margin:10px 0;">' . $texto . '</p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table style="font-size:11px;padding-top:10px;padding-left:10px;padding-right:10px;padding-bottom:25px;" cellpadding="0" cellspacing="0" border="0" align="center" width="700">
                                                <tr>
                                                    <td width="70%" valign="top"><em>Copyright © '.date('Y').' ' . $this->empresa . ', todos os direitos reservados.</em></td>
                                                    <td width="30%" style="text-align:right;">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="20px"></td>
                            </tr>
                    </table>
                    <style type="text/css">
                        @media only screen and (max-device-width: 480px) {
                            /* SMARTPHONES */
                            a[href^="tel"], a[href^="sms"] {
                                text-decoration: none;
                                color: black; /* or whatever your want */
                                pointer-events: none;
                                cursor: default;
                            }

                            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                                text-decoration: default;
                                color: orange !important; /* or whatever your want */
                                pointer-events: auto;
                                cursor: default;
                            }
                        }
                        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
                            /* TABLETS E IPADS*/
                            a[href^="tel"], a[href^="sms"] {
                                text-decoration: none;
                                color: blue; /* or whatever your want */
                                pointer-events: none;
                                cursor: default;
                            }

                            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                                text-decoration: default;
                                color: orange !important;
                                pointer-events: auto;
                                cursor: default;
                            }
                        }
                        @media only screen and (-webkit-min-device-pixel-ratio: 2) {
                            /* IPHONE RETINA */
                        }
                        @media only screen and (-webkit-device-pixel-ratio:.75){
                            /* ANDROIDS DE TELA RUIM */
                        }
                        @media only screen and (-webkit-device-pixel-ratio:1){
                            /* ANDROIDS ~NORMAIS */
                        }
                        @media only screen and (-webkit-device-pixel-ratio:1.5){
                            /* ANDROIDS DE ALTA DENSIDADE */
                        }
                    </style>';
                
                require "phpMailer/class.phpmailer.php";

                $mail = new PHPMailer();

                // Define o método de envio
                //$mail->Mailer = "smtp";

                // Define que a mensagem poderá ter formatação HTML
                $mail->IsHTML(true);

                // Define que a codificação do conteúdo da mensagem será utf-8
                $mail->CharSet = "utf-8";

                // Define que os emails enviadas utilizarão SMTP Seguro tls
                $mail->SMTPSecure = "tls";

                // Define que o Host que enviará a mensagem é o Gmail
                $mail->Host = $this->host;

                //Define a porta utilizada pelo Gmail para o envio autenticado
                $mail->Port = "465";

                // Define que a mensagem utiliza método de envio autenticado
                $mail->SMTPAuth = "true";

                // Define o usuário do gmail autenticado responsável pelo envio
                $mail->Username = $this->emailEmpresa;

                // Define a senha deste usuário citado acima
                $mail->Password = $this->senhaEmail;

                // Defina o email e o nome que aparecerá como remetente no cabeçalho
                $mail->From = $query->CON_EMAIL;
                $mail->FromName = $query->CON_NOME;

                // Define o destinatário que receberá a mensagem
                $mail->AddAddress($depa);

                /*
                  Define o email que receberá resposta desta
                  mensagem, quando o destinatário responder
                 */
                $mail->AddReplyTo($mail->From, $mail->FromName);

                // Assunto da mensagem
                $mail->Subject = "Contato Site";

                // Toda a estrutura HTML e corpo da mensagem
                $mail->Body = $msg;

                $a = $mail->Send();


                if ($a){
                    echo json_encode(array('ok' => true));
                }else{
                    echo json_encode(array('ok' => false));
                }
                
            } catch (ORM_Validation_Exception $e){
                echo json_encode(array('ok' => false));
            }
        }
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
