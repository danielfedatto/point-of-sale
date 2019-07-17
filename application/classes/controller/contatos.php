<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Contatos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Contato";
        
    }

    public function action_index() {
        $view = View::Factory("contatos");
        
        $this->template->conteudo = $view;
    }

    public function action_news() {
        $this->auto_render = FALSE;
        
        $empresa = "Point of Sale";
        if ($this->request->is_ajax()) {

            $newsletter = ORM::factory("newsletter")->where('NEW_EMAIL', '=', $this->request->post('NEW_EMAIL'))->find_all();
            if($newsletter->count() > 0){
                echo json_encode(array('ok' => false));
            }else{

                $newsletter = ORM::factory("newsletter");
                
                //INSERE
                foreach($this->request->post() as $campo => $value){
                    $newsletter->$campo = $value;
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $newsletter->save();

                    echo json_encode(array('ok' => true));
                    
                } catch (ORM_Validation_Exception $e){
                    echo json_encode(array('ok' => false));
                }
            }
        }
    }

    public function action_enviar() {
        $this->auto_render = FALSE;
        
        $empresa = "Point of Sale";
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

                $depa = "contato@costaframe.com";
                
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
                                            <img src="' . $this->dominio . 'images/logo_costa_frame.png" width="260" style="vertical-align:middle;"/>
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

}

// End quem somos
?>