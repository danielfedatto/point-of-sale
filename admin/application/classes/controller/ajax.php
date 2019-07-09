<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Ajax extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();

        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index() {
        
    }
    
    //VERIFICA SE CPF, CNPJ CADASTRADOS
    public function action_verificacpf() {
        $qtd = 1;

        $post = $this->request->post();

        $qtd = ORM::factory($post["model"])->where($post["pre"]."_CPF", "=", $post["cpf"])->count_all();
        
        $opa = ($qtd == 0) ? true : false;
        echo json_encode(array("result" => $opa));
    }
    
    public function action_verificacnpj() {
        $qtd = 1;

        $post = $this->request->post();

        $qtd = ORM::factory($post["model"])->where($post["pre"]."_CNPJ", "=", $post["cnpj"])->count_all();
        
        $opa = ($qtd == 0) ? true : false;
        echo json_encode(array("result" => $opa));
    }
    
    //BUSCA AS CIDADES, DE ACORDO COM O ESTADO
    public function action_buscamenu() {
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;

            $post = $this->request->post();
            
            $digitado = $post["digitado"];
            
            $menu = "";

            //BUSCA AS CATEGORIAS DE MODULOS DOS MÓDULOS QUE O USUÁRIO TEM PERMISSÃO
            $categoriamodulo = ORM::factory("modulos")->with("categoriamodulo")->with("modulospermissoes")
                                    ->where("PER_ID", "=", $this->sessao->get("id_permissao" . $this->nomeSessao))
                                    ->group_by("CAM_ID")->order_by("CAM_ORDEM", "asc")->find_all();
            foreach ($categoriamodulo as $cam) {
                $modulos = ORM::factory("modulos")->with("modulospermissoes")
                                            ->where("PER_ID", "=", $this->sessao->get("id_permissao" . $this->nomeSessao))
                                            ->where("CAM_ID", "=", $cam->categoriamodulo->CAM_ID)
                                                ->where("MOD_NOME", "like", "%".$digitado."%")
                                            ->order_by("MOD_NOME", "asc")->find_all();
                if($modulos->count() > 0){
                    $menu .= '
                    <li class="header">'.$cam->categoriamodulo->CAM_NOME.'</li>';
                        foreach ($modulos as $mod) {
                            //VERIFICA SE É FAVORITO PARA COLOCAR A ESTRELINHA
                            //$favorito = ORM::factory("modulosfavoritos", array($mod->MOD_ID, $idvivente));
                            if(Request::current()->controller() == $mod->MOD_LINK){
                                $active = "active";
                            }else{
                                $active = "";
                            }
                            $menu .= '
                            <li class="'.$active.'">
                                <a href="'.url::base().$mod->MOD_LINK.'">';
                                    if($mod->MOD_ICONE == ""){ 
                                        $menu .= '<i class="fa fa-link"></i>';
                                    }else{
                                        $menu .= '<i class="'.$mod->MOD_ICONE.'"></i>';
                                    }
                                    $menu .= '
                                    <span>'.$mod->MOD_NOME.'</span>';
                                $menu .= '
                                </a>
                            </li>';

                        } 
                            
                }
            }
            
            echo json_encode(array("ok" => true, "menu" => $menu));
        }
    }

    //BUSCA AS CIDADES, DE ACORDO COM O ESTADO
    public function action_trocaestado() {
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;

            $cidades = "";

            $citys = ORM::factory("cidades")->where("EST_ID", "=", $this->request->param("id"))->find_all();

            if ($citys) {
                //MONTA AS CIDADES
                $cidades .= '<div class="item-form">
                <label for="CID_ID">Cidade</label>
                <select id="CID_ID" name="CID_ID" validar="texto">
                    <option value="">Selecione...</option>';
                foreach ($citys as $cit) {
                    //SE HOUVER CIDADE COMO PARAMETRO, JA SELECIONA
                    if ($cit->CID_ID == $this->request->param("titulo"))
                        $extra = "selected";
                    else
                        $extra = "";

                    $cidades .= '
                        <option value="' . $cit->CID_ID . '" ' . $extra . ' >
                            ' . $cit->CID_NOME . '</option>';
                }
                $cidades .= '
                </select>
            </div>';
            }

            echo json_encode(array("ok" => $cidades));
        }
    }

    //VERIFICA O CEP DIGITADO, BUSCANDO CIDADE E ENDEREÇO (CORREIOS)
    public function action_cep() {
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;

            include('js/phpQuery.php');

            $html = $this->simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do', array(
                'cepEntrada' => urlencode($this->request->param("id")),
                'tipoCep' => '',
                'cepTemp' => '',
                'metodo' => 'buscarCep'
            ));

            phpQuery::newDocumentHTML($html, $charset = 'utf-8');

            $dados = array(
                'logradouro' => trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
                'bairro' => trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
                'cidade/uf' => trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
                'cep' => trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
            );

            $dados['cidade/uf'] = explode('/', $dados['cidade/uf']);
            if (count($dados['cidade/uf']) == 2) {
                $dados['cidade'] = trim($this->arrumaCidade(strtoupper($this->trataTxt($dados['cidade/uf'][0]))));
                $dados['uf'] = trim($this->arrumaCidade(strtoupper($this->trataTxt($dados['cidade/uf'][1]))));
                $dados["bairro"] = trim((($dados["bairro"])));
                $dados["logradouro"] = trim((($dados["logradouro"])));
            } else {
                $dados['cidade'] = '';
                $dados['uf'] = '';
                $dados["bairro"] = '';
                $dados["logradouro"] = '';
            }
            unset($dados['cidade/uf']);

            $cid = 0;
            $est = 0;

            $cidade = ORM::factory("cidades")->pesquisaCidadeCollate($dados["cidade"], $dados["uf"]);

            if ($cidade) {
                $cid = $cidade[0]["CID_ID"];
                $est = $cidade[0]["EST_ID"];
            }

            echo json_encode(array("ok" => $dados, "cid" => $cid, "est" => $est));
        }
    }

    protected function simple_curl($url, $post = array(), $get = array()) {
        $url = explode('?', $url, 2);
        if (count($url) === 2) {
            $temp_get = array();
            parse_str($url[1], $temp_get);
            $get = array_merge($get, $temp_get);
        }

        $ch = curl_init($url[0] . "?" . http_build_query($get));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }
    
    //FUNCAO DE TOGGLE (SETAR MODULO FAVORITO)
    public function action_favoritar(){
        $this->auto_render = FALSE;
        
        if ($this->request->is_ajax()) {
            //USUÁRIO E MÓDULO
            $usuario = $this->sessao->get('id_usuario' . $this->nomeSessao);
            $modulo = $this->request->param("id");
            
            //VERIFICA SE EXISTE
            $modulofavorito = ORM::factory("modulosfavoritos", array($modulo, $usuario));
            
            //SE EXISTE, RETIRA. SENÃO, INCLUI
            if($modulofavorito->loaded()){
                $modulofavorito->delete();
                $valor = "N";
            }else{
                $modulofavorito = ORM::factory("modulosfavoritos");
                $modulofavorito->MOD_ID = $modulo;
                $modulofavorito->USU_ID = $usuario;
                $modulofavorito->save();
                $valor = "S";
            }
            
            if($valor){
                echo json_encode(array("ok" => $valor));
            }else{
                echo json_encode(array("ok" => false));
            }
        }
    }

}

// End Ajax
