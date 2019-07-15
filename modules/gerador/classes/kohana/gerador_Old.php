<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * @package    Kohana/Gerador
 * @category   Base
 * @author     Paulo Knob
 * @copyright  (c) 2014 Paulo Knob
 */
class Kohana_Gerador {

    // Merged configuration settings
    /*
     * view -> default view
     * urlForm -> Form´s action. It´s the path where you will post the fields to generate the new module
     * urlUpload -> Path to generate the module´s files. IMPORTANT: This path need to have write permission.
     */
    protected $config = array(
        'view' => 'gerador/basic',
        'urlForm' => 'gerador/classes/kohana/gerador/salvar',
        'urlUpload' => 'upload/'
    );

    /**
     * Creates a new Gerador object.
     *
     * @param   array  configuration
     * @return  Gerador
     */
    public static function factory(array $config = array()) {
        return new Gerador($config);
    }

    /**
     * Creates a new Gerador object.
     *
     * @param   array  configuration
     * @return  void
     */
    public function __construct(array $config = array()) {
        //DELETE OLD FOLDERS
        /*$aDirectories = glob($this->config["urlUpload"]."*", GLOB_ONLYDIR);
        $data_venc = date("Y/m/d", time() - (2 * 86400));
        $i = 0;
        $aContent = false;

        foreach ($aDirectories as $sDirectory) {
            $sModified = date("Y/m/d H:i:s", filectime($sDirectory));
            $aContent[$i][$sModified] = $sDirectory;
            $i++;
        }
        
        if($aContent){
            foreach ($aContent as $aCon) {
                foreach ($aCon as $sModified => $sDirectory) {
                    $dataOnly = explode(" ", $sModified);
                    if ($dataOnly[0] <= $data_venc) {

                        //TAKE MODULE
                        $modulo = explode("/", $sDirectory);
                        $modulo = $modulo[1];

                        array_map('unlink', glob($sDirectory . "/controller/*.php"));
                        array_map('unlink', glob($sDirectory . "/view/" . $modulo . "/*.php"));
                        array_map('unlink', glob($sDirectory . "/messages/" . $modulo . ".php"));
                        array_map('unlink', glob($sDirectory . "/model/" . $modulo . ".php"));

                        if (is_dir($sDirectory . "/controller")) {
                            rmdir($sDirectory . "/controller");
                        }

                        if (is_dir($sDirectory . "/view/" . $modulo)) {
                            rmdir($sDirectory . "/view/" . $modulo);
                        }

                        if (is_dir($sDirectory . "/view")) {
                            rmdir($sDirectory . "/view");
                        }

                        if (is_dir($sDirectory . "/messages")) {
                            rmdir($sDirectory . "/messages");
                        }

                        if (is_dir($sDirectory . "/model")) {
                            rmdir($sDirectory . "/model");
                        }

                        if (is_dir($sDirectory)) {
                            rmdir($sDirectory);
                        }
                    }
                }
            }
        }*/
        
        // Gerador setup
        $this->setup($config);
    }

    /**
     * Loads configuration settings into the object.
     *
     * @param   array   configuration
     * @return  object  Gerador
     */
    public function setup(array $config = array()) {
        
        // Overwrite the current config settings
        $this->config = $config + $this->config;

        // Chainable method
        return $this;
    }
    
    /**
     * Renders the gerador view.
     *
     * @param   mixed   string of the view to use, or a Kohana_View object
     * @return  string  gerador output (HTML)
     */
    public function render($view = NULL) {
        if ($view === NULL) {
            // Use the view from config
            $view = $this->config['view'];
        }

        if (!$view instanceof View) {
            // Load the view file
            $view = View::factory($view);
        }
        
        //Throws the config to View
        $view->config = $this->config;

        // Pass on the whole Gerador object
        return $view->set(get_object_vars($this))->set('page', $this)->render();
    }
    
    /**
     * Renders the gerador links.
     *
     * @return  string  gerador output (HTML)
     */
    public function __toString() {
        try {
            return $this->render();
        } catch (Exception $e) {
            Kohana_Exception::handler($e);
            return '';
        }
    }
    
    //Generate new Module
    public function salvar($post) {

            $tabela = strtoupper($this->trataTxt($post['fTabela']));
            
            //PEGA OS 3 PRIMEIROS CARACTERES DA TABELA
            if (strpos($tabela, "_")) {
                $temp = explode("_", $tabela);
                $carc = substr($temp[0], 0, 2);
                $carc .= substr($temp[1], 0, 1);
                //DECLARA QUE O CARACTER SEPARADOR É O "_"
                $separador = "_";
            } else if (strpos($tabela, " ")) {
                $temp = explode(" ", $tabela);
                $carc = substr($temp[0], 0, 2);
                $carc .= substr($temp[1], 0, 1);
                //DECLARA QUE O CARACTER SEPARADOR É O " "
                $separador = " ";
            } else {
                $carc = substr($tabela, 0, 3);
                //POR DEFAULT, DECLARA QUE O CARACTER SEPARADOR É O "_"
                $separador = "_";
            }

            //CRIA OS DIRETORIOS
            
            /*if (!is_dir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))))) {
                mkdir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))), 0777);
                mkdir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/controller", 0777);
                mkdir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/model", 0777);
                mkdir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/messages", 0777);
                mkdir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/view", 0777);
                mkdir($this->config["urlUpload"] . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/view/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))), 0777);
            }*/
            if (!is_dir($this->config["urlUpload"] . "views/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))))) {
                mkdir($this->config["urlUpload"] . "views/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))), 0777);
            }
            
            //CRIA A PASTA UPLOAD, SE TIVER IMAGEM OU ARQUIVO
            if(in_array("IMAGEM", $post["fTipo"]) or in_array("ARQUIVO", $post["fTipo"])){
                if (!is_dir(getcwd() . "/upload/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))))) {
                    mkdir(getcwd() . "/upload/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))), 0777);
                }
            }

//GERA TABELA
            $geraTabela = 'Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS ' . str_replace(" ", "_", $tabela) . ' (
            '; 
            
            //CHAVES PRIMARIAS
            $id = array();
            $primary = '';
            $foreign = '';
            
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR IMAGEM OU ARQUIVO, NÃO ADICIONA NO BANCO
                        if ($post["fTipo"][$i] != "IMAGEM" and $post["fTipo"][$i] != "ARQUIVO") {

                            $def = "";
                            $tam = "";

                            //SE HOUVER VALOR DEFAULT E NÃO FOR CHAVE ESTRANGEIRA, SETA NA TABELA
                            if ($post["fDefault"][$i] != "" and $post["fRef"][$i] == "") {
                                //SE FOR TIPO SET, PEGA SÓ A PRIMEIRA LETRA
                                if($post["fTipo"][$i] == "SET"){
                                    $def = ' default \'' . substr($post["fDefault"][$i], 0, 1) . '\'';
                                }else if($post["fTipo"][$i] == "TIMESTAMP"){
                                    //SE FOR TIPO TIMESTAMP, NAO COLOCA ASPAS
                                    $def = ' default ' . $post["fDefault"][$i] . '';
                                }else{
                                    $def = ' default \'' . $post["fDefault"][$i] . '\'';
                                }
                            }

                            //SETA O TAMANHO DE SE HOUVER, OU SE FOR DECIMAL/SET
                            if (($post["fTamanho"][$i] > 0) or ($post["fTipo"][$i] == "DECIMAL" or $post["fTipo"][$i] == "SET")) {
                                //SE FOR TIPO SET, PEGA SÓ A PRIMEIRA LETRA DE CADA VALOR
                                if($post["fTipo"][$i] == "SET"){
                                    $valoresSet = explode(",", $post['fTamanho'][$i]);
                                    
                                    $tam = '(';
                                    
                                    $g = 0;
                                    foreach($valoresSet as $vas){
                                        if($g > 0)  $tam .= ",";
                                        $tam .= '\''.substr($vas, 0, 1).'\'';
                                        $g++;
                                    }
                                    
                                    $tam .= ')';
                                }else{
                                    $tam = '(' . $post['fTamanho'][$i] . ')';
                                }
                            }

                            //TESTA SE É CHAVE ESTRANGEIRA. SE FOR, ADICIONA O PREFIXO DA TABELA EM QUESTÃO. SENÃO, CAMPO NORMAL
                            if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                }else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                }
                                
                                $campoTabela = strtoupper($carcEst)."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))));
                                
                                //ADICIONA NA VARIÁVEL PARA ADICIONAR O CONSTRAINT NO FINAL DO SQL
                                $foreign .= ',
            FOREIGN KEY ('.$campoTabela.') REFERENCES '.str_replace(" ", "_", strtoupper($this->trataTxt($post["fRef"][$i]))).'('.$campoTabela.') ON DELETE RESTRICT ON UPDATE RESTRICT';
                            }else{
                                $campoTabela = $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                            }
                            
                            //SE FOR CHAVE PRIMÁRIA, ADICIONA O CAMPO. SENÃO, ADICIONA NORMALMENTE
                            if($post["fPrimaria"][$i] == "S"){
                                
                                if($primary != ""){
                                    $primary .= ', ';
                                }
                                
                                //$primary .= $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                                $primary .= $campoTabela;
                                
                                //ADICIONA A CHAVE PRIMARIA NO ARRAY $ID
                                array_push($id, strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))));
                                
                                //SE FOR AUTO INCREMENT, SETA ESSE CAMPO
                                if($post["fAuto"][$i] == "S"){
                                    $auto = ' auto_increment';
                                }else{
                                    $auto = '';
                                }
                                
            $geraTabela .= $campoTabela . ' ' . $post['fTipo'][$i] . ' ' . $tam . ' unsigned NOT NULL'.$auto.',
            ';
                            }else{
                                
                                //SE FOR CHAVE ESTRANGEIRA, ADICIONA O UNSIGNED
                                if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                    $unsig = ' unsigned';
                                }else{
                                    $unsig = '';
                                }
                                
                                //SE FOR TIPO PASSWORD, NAO ADICIONA O POST[FTIPO], E SIM VARCHAR
                                if($post['fTipo'][$i] == "PASSWORD"){
            $geraTabela .=  $campoTabela. ' VARCHAR ' . $tam . $unsig.' NOT NULL' . $def . ',
            ';
                                }else{
            $geraTabela .=  $campoTabela. ' ' . $post['fTipo'][$i] . ' ' . $tam . $unsig.' NOT NULL' . $def . ',
            ';
                                }
                                
            
                            }
                        }
                    }
                }
            }

            $geraTabela .= 'PRIMARY KEY  (' . $primary . ')'.$foreign.'
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");';
            
            //GERA A MESSAGE
            // diretório onde encontra-se o arquivo
            $filename = $this->config["urlUpload"] . "messages/models/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ".php";
            
//Adciona um novo texto
            $message = '<?php

//These corespond to the fields that we are invalidating in our model and the error message that will be displayed on our form
return array(';
            
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR IMAGEM OU ARQUIVO, OU CHAVE PRIMÁRIA, OU TIMESTAMP, E SEJA REQUIRED NÃO ADICIONA MENSAGEM
                        if ($post["fTipo"][$i] != "IMAGEM" and $post["fTipo"][$i] != "ARQUIVO" and $post["fTipo"][$i] != "TIMESTAMP"
                                and $post["fPrimaria"][$i] != "S" and $post["fReq"][$i] == "S") {

                            //TESTA SE É CHAVE ESTRANGEIRA. SE FOR, ADICIONA O PREFIXO DA TABELA EM QUESTÃO E A MESSAGE DO EXISTS
                            if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                }else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                }
                                
                                $campoTabela = strtoupper($carcEst)."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))));
                                
                                $message .= '
    "'.$campoTabela.'" => array(
        "not_empty" => "'.$post['fRef'][$i].' não pode ser vazio.",
        "exists'.ucwords(strtolower($carcEst)).'" => "Esse '.$post['fRef'][$i].' não existe."
    ),';
                            }else if($post["fTipo"][$i] == "SET"){
                                
                                $funcao = 'valor';
                                $tamanhos = explode(",", $post["fTamanho"][$i]);
                                foreach($tamanhos as $tamanho){
                                    $funcao .= strtoupper($tamanho[0]);
                                }
                                
                                //SE FOR CONJUNTO, ADICIONA O VERIFICADOR DE POSSIBILIDADES
                                $message .= '
    "'.$carc.'_'.strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
        "not_empty" => "'.$post['fCampo'][$i].' não pode ser vazio.",
        "'.$funcao.'" => "'.$post['fCampo'][$i].': Valor inválido."
    ),';
                            }else{
                                //ADICIONA O BÁSICO
                                $message .= '
    "'.$carc.'_'.strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
        "not_empty" => "'.$post['fCampo'][$i].' não pode ser vazio.",';
                                
                                //SE FORM STRING OU SENHA, ADICIONA OS LIMITADORES DE TAMANHO
                                if($post["fTipo"][$i] == "VARCHAR" or $post["fTipo"][$i] == "PASSWORD"){
                                
                                $message .= '
        "min_length" => "'.$post['fCampo'][$i].' deve ter pelo menos 3 caracteres.",
        "max_length" => "'.$post['fCampo'][$i].' deve ter no máximo '.$post["fTamanho"][$i].' caracteres."';
                                }
                                
                                $message .= '
    ),';
                            }
                        }
                    }
                }
            }
            
            $message .= '
);
?>                
';

            //SALVANDO
            $file = fopen($filename, "w+");
            fwrite($file, stripslashes($message));
            fclose($file);
            
            //GERA O MODEL
            // diretório onde encontra-se o arquivo
            $filename = $this->config["urlUpload"] . "classes/model/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ".php";
            
//Adciona um novo texto
            $model = '<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_' . ucwords(strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela'])))) . ' extends ORM {

    protected $_table_name = "' . str_replace(" ", "_", $tabela) . '";
    protected $_primary_key = "' . $carc . '_'.$id[0].'";
    protected $_sorting = array("' . $carc . '_'.$id[0].'" => "asc");';
    
        //SE HOUVER CHAVE ESTRANGEIRA OU HAS, ADICIONA O RELATIONSHIP
        if (array_key_exists('fRef', $post) or array_key_exists('fHas', $post)) {
            
            $model .= '
    
    //RELATIONSHIP';
            
            //SE HOUVER CHAVE ESTRANGEIRA, ADICIONA OS BELONGS_TO
            if (is_array($post['fRef'])) {
                
                $model .= '
    protected $_belongs_to = array(';
                
                $max = count($post['fRef']);
                for ($i = 0; $i < $max; $i++) {
                    if ($post['fRef'][$i] != "" and $post['fTipo'][$i] == "INT") {
                        //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                        if (strpos($post["fRef"][$i], "_")) {
                            $temp = explode("_", $post["fRef"][$i]);
                            $carcEst = substr($temp[0], 0, 2);
                            $carcEst .= substr($temp[1], 0, 1);
                            $sep = "_";
                        }else if (strpos($post["fRef"][$i], " ")) {
                            $temp = explode(" ", $post["fRef"][$i]);
                            $carcEst = substr($temp[0], 0, 2);
                            $carcEst .= substr($temp[1], 0, 1);
                            $sep = " ";
                        } else {
                            $carcEst = substr($post["fRef"][$i], 0, 3);
                            $sep = " ";
                        }
                        $carcEst = strtoupper($this->trataTxt($carcEst));
                                
                        $model .= '
        "'.strtolower(str_replace($sep, "", $this->trataTxt($post['fRef'][$i]))).'" => array(
            "model"       => "'.strtolower(str_replace($sep, "", $this->trataTxt($post['fRef'][$i]))).'",
            "foreign_key" => "'.$carcEst.'_ID",
        ),';
                    }
                }
                
                $model .= '
    );';
            }
            
            //SE HOUVER HAS, ADICIONA OS HAS_MANY
            if (is_array($post['fHas'])) {
                
                $model .= '
    protected $_has_many = array(';
                
                $max = count($post['fHas']);
                for ($i = 0; $i < $max; $i++) {
                    if ($post['fHas'][$i] != "") {
                        
                        //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                        if (strpos($post["fHas"][$i], "_")) {
                            $temp = explode("_", $post["fHas"][$i]);
                            $carcEst = substr($temp[0], 0, 2);
                            $carcEst .= substr($temp[1], 0, 1);
                            $sep = "_";
                        }else if (strpos($post["fHas"][$i], " ")) {
                            $temp = explode(" ", $post["fHas"][$i]);
                            $carcEst = substr($temp[0], 0, 2);
                            $carcEst .= substr($temp[1], 0, 1);
                            $sep = " ";
                        } else {
                            $carcEst = substr($post["fHas"][$i], 0, 3);
                            $sep = " ";
                        }
                        $carcEst = strtoupper($this->trataTxt($carcEst));
                        
                        $model .= '
        "'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).'" => array(
            "model"       => "'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).'",
            "foreign_key" => "'.$carc.'_ID",
        ),';
                    }
                }
                
                $model .= '
    );';
            }
            
        }
            
            $model .= '
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(';
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR IMAGEM OU ARQUIVO, OU FOR CHAVE PRIMARIA, OU TIMESTAMP, E SEJA REQUIRED NÃO ADICIONA NAS RULES
                        if ($post["fTipo"][$i] != "IMAGEM" and $post["fTipo"][$i] != "ARQUIVO" and $post["fTipo"][$i] != "TIMESTAMP" 
                                and $post["fPrimaria"][$i] != "S" and $post["fReq"][$i] == "S") {
                            //SE FOR CHAVE ESTRANGEIRA, TEM QUE PEGAR O PREFIXO DA TABELA DELE
                            if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                }else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                }
                                $carcEst = strtoupper($this->trataTxt($carcEst));
                                
            $model .= '
            "'.$carcEst."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
                array("not_empty"),
                array(array($this, "exists'.ucwords(strtolower($carcEst)).'")),';
            
            $model .= '
            ),';
                                
                            }else{
            $model .= '
            "'.$carc."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
                array("not_empty"),';
            
                            //SE FOR SET, COLOCA A FUNÇÃO DE VALIDAÇÃO
                            if (($post["fTipo"][$i] == 'SET')) {
                                $funcao = 'valor';
                                $tamanhos = explode(",", $post["fTamanho"][$i]);
                                foreach($tamanhos as $tamanho){
                                    $funcao .= strtoupper($tamanho[0]);
                                }
                                
            $model .= '
                array(array($this, "'.$funcao.'")),';
                            }
                            
                            //SE TAMANHO MAIOR QUE ZERO, COLOCA O MIN E O MAX
                            if (($post["fTamanho"][$i] > 0) and ($post["fTipo"][$i] == 'VARCHAR' or $post["fTipo"][$i] == 'PASSWORD')) {
            $model .= '
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", '.$post["fTamanho"][$i].')),';
                            }
                            
                $model .= '
            ),';   
                            }
                        }
                    }
                }
            }
            
            $model .= '
        );
    }
    
    //FILTROS
    public function filters(){
        return array(';
        if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        if ($post["fTipo"][$i] == "DATE") {
            $model .= '
            "'.$carc."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
                array(array($this, "arrumaData")),
            ),';
                        }
        
                        if ($post["fTipo"][$i] == "DECIMAL") {
            $model .= '
            "'.$carc."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
                array(array($this, "arrumaValor")),
            ),';
                        }
                        
                        if ($post["fTipo"][$i] == "PASSWORD") {
            $model .= '
            "'.$carc."_".strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'" => array(
                array(array($this, "criptografaSenha")),
            ),';
                        }
                    }
                }
        }
            
            $model .= '
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        '.$geraTabela.'
        
        parent::__construct($id);
    }';
            
    //SE HOUVER CHAVE ESTRANGEIRA OU HAS, ADICIONA O RELATIONSHIP
    if (array_key_exists('fRef', $post)) {
        //SE HOUVER CHAVE ESTRANGEIRA, ADICIONA OS BELONGS_TO
        if (is_array($post['fRef'])) {
            $max = count($post['fRef']);
            for ($i = 0; $i < $max; $i++) {
                if ($post['fRef'][$i] != "" and $post['fTipo'][$i] == "INT") {
                    //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                    if (strpos($post["fRef"][$i], "_")) {
                        $temp = explode("_", $post["fRef"][$i]);
                        $carcEst = substr($temp[0], 0, 2);
                        $carcEst .= substr($temp[1], 0, 1);
                    }else if (strpos($post["fRef"][$i], " ")) {
                        $temp = explode(" ", $post["fRef"][$i]);
                        $carcEst = substr($temp[0], 0, 2);
                        $carcEst .= substr($temp[1], 0, 1);
                    } else {
                        $carcEst = substr($post["fRef"][$i], 0, 3);
                    }
                    $carcEst = strtoupper($this->trataTxt($carcEst));

                    $model .= '
                        
    //CHECA SE A '.strtoupper($this->trataTxt($post['fRef'][$i])).' EXISTE
    public static function exists'.ucwords(strtolower($carcEst)).'($id) {
        $results = DB::select("*")->from("'.strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fRef'][$i])))).'")->where("'.$carcEst.'_'.strtoupper(str_replace(" ", "_", str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'", "=", $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }';
                }
            }
        }
            
    }
    
    //SE HOUVER SET, ADICIONA A FUNÇÃO
    if (array_key_exists('fCampo', $post)) {
        if (is_array($post['fCampo'])) {
            $max = count($post['fCampo']);
            for ($i = 0; $i < $max; $i++) {
                //SE TIPO FOR SET E NÃO FOR O DEFAULT (Sim OU Não), ADICIONA
                if ($post["fTipo"][$i] == "SET" and $post["fTamanho"][$i] != "Sim,Não") {
                    
                    $tamanhos = explode(',', $post["fTamanho"][$i]);
                    
                    //VALORES POSSÍVEIS
                    $valores1 = "";
                    $valores2 = "";
                    $valores3 = "";
                    $valores4 = "valor";
                    $flag = 0;
                    
                    foreach($tamanhos as $tamanho){
                        if($flag > 0){
                            $valores1 .= " OU ";
                            $valores2 .= " OU ";
                            $valores3 .= " and ";
                        }
                        
                        $valores1 .= '"'.strtoupper($tamanho[0]).'"';
                        $valores2 .= $tamanho;
                        $valores3 .= '$valor != "'.strtoupper($tamanho[0]).'"';
                        $valores4 .= strtoupper($tamanho[0]);
                        
                        $flag++;
                    }
                    
                    $model .= '
    
    //ACEITA APENAS OS VALORES '.$valores1.' (PARA VALOR '.$valores2.')
    public function '.$valores4.'($valor) {
        //VERIFICA SE VALOR É VALIDO
        if('.$valores3.'){
            return false;
        }else    return true;
    }';
                    
                }
            }
        }
    }
            
    //FECHA O MODEL
            $model .= '
}
';

            //SALVANDO
            $file = fopen($filename, "w+");
            fwrite($file, stripslashes($model));
            fclose($file);
            
            //GERA O CONTROLADOR
            // diretório onde encontra-se o arquivo
            $filename = $this->config["urlUpload"] . "classes/controller/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ".php";

//Adciona um novo texto
            $controlador = '<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_' . ucwords(strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela'])))) . ' extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - ' . ucwords(strtolower($post['fTabela'])) . '";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {

        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory("' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/list");
        
        //BUSCA OS REGISTROS        
        $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = ORM::factory("' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '")';
            
        //SE HOUVER CHAVE ESTRANGEIRA, FAZ BUSCAR OS REGISTROS
        if (array_key_exists('fRef', $post)) {
            if (is_array($post['fRef'])) {
                $max = count($post['fRef']);
                for ($i = 0; $i < $max; $i++) {
                    if ($post['fRef'][$i] != "" and $post['fTipo'][$i] == "INT") {
                        //PEGA O SEPARADOR
                        if (strpos($post["fRef"][$i], "_")) {
                            $sep = "_";
                        }else if (strpos($post["fRef"][$i], " ")) {
                            $sep = " ";
                        } else {
                            $sep = " ";
                        }
                        
                        $controlador .= '->with("'.strtolower(str_replace($sep, "", $this->trataTxt($post['fRef'][$i]))).'")';
                    }
                }
            }
        }
            
            $controlador .= ';';
        
            $busca = '"'.$carc . '_' . $id[0] . '"=>"'.$carc . '_' . $id[0] . '"';
            $itemPesquisa = '';
            //PREENCHE A BUSCA COM OS CAMPOS MARCADOS PARA TAL
            if (array_key_exists('fPesquisar', $post)) {
                if (is_array($post['fPesquisar'])) {
                    $max = count($post['fPesquisar']);
                    $j = 0;
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fPesquisar'][$i] == "S") {
                            
                            //SE FOR CHAVE ESTRANGEIRA, NÃO PEGA, PEGA O DEFAULT. SENÃO, NORMAL
                            if ($post['fRef'][$i] != "" and $post['fTipo'][$i] == "INT") {
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                }else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                }
                                $carcEst = strtoupper($this->trataTxt($carcEst));
                                
                                if($j == 0){
                                    $itemPesquisa .= '->where("'.$carcEst . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fDefault'][$i]))).'", "like", "%".$this->sane($_GET["chave"])."%")';
                                }else{
                                    $itemPesquisa .= '->or_where("'.$carcEst . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fDefault'][$i]))).'", "like", "%".$this->sane($_GET["chave"])."%")';
                                }
                                
                                $j++;                            
                            
                                //$busca .= ', "'.$carcEst . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fDefault'][$i]))) . '"=>"'.$carcEst . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fDefault'][$i]))) . '"';
                            }else{
                                //CHECA O TIPO DO CAMPO, PARA FAZER A PESQUISA CORRETA
                                $tipo = $post['fTipo'][$i];
                                if ($tipo == "DATE") {
                                    $valorCampo = '$this->ddmmaaaa_aaaammdd(addslashes($_GET["chave"]))';
                                } else if ($tipo == "DECIMAL") {
                                    $valorCampo = 'str_replace(",", ".", str_replace(".", "", $_GET["chave"]))';
                                } else {
                                    $valorCampo = '$_GET["chave"]';
                                }
                                
                                if($j == 0){
                                    $itemPesquisa .= '->where("'.$carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'", "like", "%".$this->sane('.$valorCampo.')."%")';
                                }else{
                                    $itemPesquisa .= '->or_where("'.$carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'", "like", "%".$this->sane('.$valorCampo.')."%")';
                                }
                                
                                $j++;                            
                            
                                $busca .= ', "'.$carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"=>"'.$carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"';
                            }
                        }
                    }
                }
            }
            
            $controlador .= '
                
        //SETA AS COLUNAS QUE VAI BUSCAR
        $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '->setColumns(array('.$busca.'));
        
        //TESTA SE TEM PESQUISA
        if(isset($_GET["chave"])){
            $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . $itemPesquisa.';
        }
        
        //PAGINAÇÃO
        $paginas = $this->action_page($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ', $this->qtdPagina);
        $view->' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = $paginas["data"];
        $view->pagination = $paginas["pagination"];
        
        //PASSA A MENSAGEM
        $view->mensagem = $mensagem;
        $view->erro = $erro;
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }

    //FORMULARIO DE CADASTRO
    public function action_edit(){
        //INSTANCIA A VIEW DE EDICAO
        $view = View::Factory("' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/edit");
        
        $id = $this->request->param("id");
        ';
        
        //SE HOUVER CHAVE ESTRANGEIRA, FAZ BUSCAR OS REGISTROS
        if (array_key_exists('fRef', $post)) {
            if (is_array($post['fRef'])) {
                $max = count($post['fRef']);
                for ($i = 0; $i < $max; $i++) {
                    if ($post['fRef'][$i] != "" and $post['fTipo'][$i] == "INT") {
                        //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                        if (strpos($post["fRef"][$i], "_")) {
                            $temp = explode("_", $post["fRef"][$i]);
                            $carcEst = substr($temp[0], 0, 2);
                            $carcEst .= substr($temp[1], 0, 1);
                        }else if (strpos($post["fRef"][$i], " ")) {
                            $temp = explode(" ", $post["fRef"][$i]);
                            $carcEst = substr($temp[0], 0, 2);
                            $carcEst .= substr($temp[1], 0, 1);
                        } else {
                            $carcEst = substr($post["fRef"][$i], 0, 3);
                        }
                                
                        $controlador .= '
        //BUSCA '.str_replace("_", " ", strtoupper($this->trataTxt($post['fRef'][$i]))).'
        $view->'.str_replace(" ", "", strtolower($this->trataTxt($post['fRef'][$i]))).' = ORM::factory("'.str_replace(" ", "", strtolower($this->trataTxt($post['fRef'][$i]))).'")->find_all();
                            ';
                    }
                }
            }
        }
            
        $controlador .= '
        //SE EXISTIR O ID, BUSCA O REGISTRO
        if($id){
            //BUSCA O REGISTRO E PREENCHE OS CAMPOS
            $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = ORM::factory("' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '");
            $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '->where($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '->primary_key(), "=", $this->sane($id))->find();
            ';

            $controlador .= '
            $arr = array(';

            //PREENCHE O ARRAY DE CAMPOS DA TABELA
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR IMAGEM, ARQUIVO OU SENHA, NÃO ADICIONA NO ARRAY
                        if ($post["fTipo"][$i] != "IMAGEM" and $post["fTipo"][$i] != "ARQUIVO" and $post["fTipo"][$i] != "PASSWORD") {
                            
                            //TESTA SE É CHAVE ESTRANGEIRA. SE FOR, ADICIONA O PREFIXO DA TABELA EM QUESTÃO
                            if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                }
                                
                                $campoTabela = strtoupper($carcEst)."_".strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                            }else{
                                $campoTabela = $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                            }
                            
                            //SE FOR TIMESTAMP, NÃO EDITA
                            if($post["fTipo"][$i] != "TIMESTAMP"){
                $controlador .= '
                "' . $campoTabela . '" => $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '->' . $campoTabela . ',';
                            }
                        }
                    }
                }
            }

            $controlador .= '
            );
            
            $view->' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = $arr;';
                
            //SE HOUVER IMAGEM, ADICIONA PARA BUSCA-LA
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                //CONTADOR DE IMAGENS
                $maxImagem = 0;
                $extraImagem = '';
                
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        //SE NÃO FOR A PRIMEIRA IMAGEM, PRECISA DE UM NOME DIFERENTE PARA SALVAR IMAGENS DIFERENTES
                        if($maxImagem > 0){
                            $extraImagem = strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_';
                        }
                        
                        $controlador .= '
                    
            //BUSCA A '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).', SE HOUVER
            $'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'thumb_" . $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '->'.$carc.'_'.$id[0].' . ".*");
            if ($'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).') {
                $view->'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = "<div class=\'item-form\'>
                        <label>Excluir '.ucwords(($post["fCampo"][$i])).'</label>
                        <input type=\'checkbox\' id=\'excluir'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'\' name=\'excluir'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'\'>
                        <img src=\'" . url::base() . $'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'[0] . "\'>
                    </div>";
            }
            else {
                $view->'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = false;
            }';
                        
                        //INCREMENTA
                        $maxImagem++;
                    }
                }
            }
            
            //SE HOUVER ARQUIVO, ADICIONA PARA BUSCA-LO
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
                    
            //BUSCA O '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).', SE HOUVER
            $'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_" . $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '->'.$carc.'_'.$id[0].' . ".*");
            if ($'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).') {
                $view->'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = "<div class=\'item-form\'>
                        <label>Excluir '.ucwords(($post["fCampo"][$i])).'</label>
                        <input type=\'checkbox\' id=\'excluir'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'\' name=\'excluir'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'\'>
                        Arquivo Cadastrado!!
                    </div>";
            }
            else {
                $view->'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = false;
            }';
                    }
                }
            }
            
            $controlador .= '
        }else{
            //SENAO, SETA COMO VAZIO
            $arr = array( 
                "' . $carc . '_'.$id[0].'" => "0",';

            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR IMAGEM, ARQUIVO OU SENHA, OU AINDA FOR CHAVE PRIMARIA, NÃO ADICIONA NO ARRAY
                        if ($post["fTipo"][$i] != "IMAGEM" and $post["fTipo"][$i] != "ARQUIVO" and $post["fTipo"][$i] != "PASSWORD" 
                                and $post["fPrimaria"][$i] != "S") {
                            
                            //TESTA SE É CHAVE ESTRANGEIRA. SE FOR, ADICIONA O PREFIXO DA TABELA EM QUESTÃO
                            if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                }else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                }
                                
                                $campoTabela = strtoupper($carcEst)."_".strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                            }else{
                                $campoTabela = $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                            }
                            
                            //SE FOR DATA, TIME, SET OU CHAVE ESTRANGEIRA, O DEFAULT PUXA DO PHP. SENAO, COLOCA NORMAL
                            //SE FOR TIMESTAMP, NÃO EDITA
                            if($post["fTipo"][$i] != "TIMESTAMP"){
                                if($post["fTipo"][$i] == "DATE"){
                                $controlador .= '
                "' . $campoTabela . '" => date("Y-m-d"),';
                                }else if($post["fTipo"][$i] == "TIME"){
                                $controlador .= '
                "' . $campoTabela . '" => date("G:i"),';
                                }else if($post["fTipo"][$i] == "SET"){
                                $controlador .= '
                "' . $campoTabela . '" => "' . substr($post["fDefault"][$i], 0, 1) . '",';
                                }else if($post["fRef"][$i] != "" and $post["fTipo"][$i] == "INT"){
                                $controlador .= '
                "' . $campoTabela . '" => "",';
                                }else{
                                $controlador .= '
                "' . $campoTabela . '" => "' . $post["fDefault"][$i] . '",';
                                }
                            }
                        }
                    }
                }
            }

            $controlador .= '
            );
            
            $view->' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' = $arr;';
            
            //SE HOUVER IMAGEM, ADICIONA PARA SETA-LA COMO FALSE
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        $controlador .= '
            $view->'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = false;';
                    }
                }
            }
            
            //SE HOUVER ARQUIVO, ADICIONA PARA SETA-LO COMO FALSE
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
            $view->'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' = false;';
                    }
                }
            }
            
            $controlador .= '
        }
        
        $this->template->bt_voltar = true;
        
        $this->template->conteudo = $view;
    }
    
    //SALVA INFORMACOES
    public function action_save(){

        //MENSAGEM DE OK, OU ERRO
        $mensagem = "Registro alterado com sucesso!";
';
            //SE HOUVER ARQUIVO, ADICIONA PARA O EXCLUIRIMAGEM COMO FALSE. TAMBÉM JÁ ARRUMA NO SQL, PARA NÃO ADICIONAR ESSE CAMPO            
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        $controlador .= '
        $exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).' = false;
                ';
                    }
                }
            }
            
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
        $exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).' = false;
                ';
                    }
                }
            }

            $controlador .=
                    '
        //SE O ID ESTIVER ZERADO, INSERT
        if($this->request->post("' . $carc . '_'.$id[0].'") == "0" ){ 
            
            $'.strtolower(str_replace(" ", "", $this->trataTxt($post['fTabela']))).' = ORM::factory("'.strtolower(str_replace(" ", "", $this->trataTxt($post['fTabela']))).'");';
            
            $controlador .= '
            
            //INSERE
            foreach($this->request->post() as $campo => $value){';
            
            //TESTA SE EXISTE SENHA, PARA IGNORAR O CONFIRMAR SENHA
            if(in_array("PASSWORD", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                $controlador .= '
                if(';
                
                $flag42 = "";
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR SENHA, ADICIONA NO IF
                    if ($post["fTipo"][$i] == "PASSWORD") {
                        $controlador .= $flag42.' $campo != "' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C"';
                        if($flag42 == ""){
                            $flag42 = " and";
                        }
                    }
                }
                
                $controlador .= '){
            ';
            }
            
            //DEFINE OS ITENS PARA ARRUMAR OS CAMPOS
            $default = '';
            $flag = "if";
            $qntCampos = 0;

            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR ARQUIVO, OU AINDA CHAVE PRIMARIA INCREMENT, NÃO ADICIONA NO ARRAY. SE FOR IMAGEM, DEIXA ZERADO
                        if ($post["fTipo"][$i] != "ARQUIVO"
                                and $post["fPrimaria"][$i] != "S" and $post["fAuto"][$i] != "S") {
                            $tipo = $post['fTipo'][$i];
                            if ($tipo == "PASSWORD") {
                                $default .= '
                '.
                $flag.' ($campo == "' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '") {
                //TESTA SENHA VAZIA, NAO SALVAR
                if ($value == "") {
                    continue;
                }
                else {
                    if ($value == $this->request->post("' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C"))
                        $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->$campo = $value;
                }
            }';
                                $flag = "else if";
                                $qntCampos++;
                            } else if ($tipo == "IMAGEM") {
                                $default .= '
                '.
            $flag . ' ($campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'Blob" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'x1" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'y1" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'w" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'h") {
                    //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                }';
                                $flag = "else if";
                                $qntCampos++;
                            }
                        }
                    }

                    //SE ENCONTROU UM, FEZ O IF ELSE. SENÃO, TEM QUE SETAR O VALOR DEFAULT
                    if ($qntCampos > 0) {
                        $default .= 'else{ 
                    $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->$campo = $value;
                }';
                    } else {
                        $default .= '
                $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->$campo = $value;';
                    }

                    $controlador .= $default;
                    
                    //SE TEM SENHA, TEM QUE FECHAR O IF LÁ DE CIMA
                    if(in_array("PASSWORD", $post["fTipo"])){
                        $controlador .= '
            }';
                    }
                }
            }
            
            $controlador .= '
            }
            
            //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
            try{
                $query = $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->save();
                $mensagem = "Registro inserido com sucesso!";';
            
            //SE HOUVER IMAGEM, ADICIONA PARA SETA-LA COMO FALSE
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                //CONTADOR DE IMAGENS
                $maxImagem = 0;
                $extraImagem = '';
                
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        
                        //SE NÃO FOR A PRIMEIRA IMAGEM, PRECISA DE UM NOME DIFERENTE PARA SALVAR IMAGENS DIFERENTES
                        if($maxImagem > 0){
                            $extraImagem = strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_';
                        }
                        
                    $controlador .= '

                //INSERE A '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).', SE EXISTIR
                if ($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob") != "") {
                    $imgBlob = $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob");

                    if(strpos($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob"), "image/jpg") or strpos($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob"), "image/jpeg")){
                        //JPEG
                        $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                        $ext = "jpg";
                    }else if(strpos($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob"), "image/png")){
                        //PNG
                        $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                        $ext = "png";
                    }

                    $imgBlob = str_replace(" ", "+", $imgBlob);
                    $data = base64_decode($imgBlob);

                    //imagem tamanho normal
                    $imgName = "'.$extraImagem.'".$'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . ".".$ext;
                    file_put_contents(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName, $data);

                    //CROP
                    if($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'w") != "" and $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'w") > 0){
                        $img = Image::factory(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                        $img = $img->crop($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'w"), $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'h"), $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'x1"), $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'y1"))->save(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                    }

                    //thumb
                    $img = Image::factory(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                    $imgName = "'.$extraImagem.'thumb_" . $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . ".".$ext;
                    $img->resize(200)->save(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                }';
                        
                        //INCREMENTA
                        $maxImagem++;
                    }
                }
            }
            
            //SE HOUVER ARQUIVO, ADICIONA PARA SETA-LO COMO FALSE
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
                            
                //INSERE O ARQUIVO, SE EXISTIR
                if ($_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["name"] != "") {

                    $ext = explode(".", $_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["name"]);
                    $arqName = "'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_".$'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . "." . $ext[count($ext) - 1];

                    if($ext[count($ext) - 1] == "doc" or $ext[count($ext) - 1] == "docx" or $ext[count($ext) - 1] == "pdf"){
                        copy($_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["tmp_name"], DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$arqName);
                    }
                }';
                    }
                }
            }
            
            $controlador .= '
            } catch (ORM_Validation_Exception $e){
                $query = false;
                $mensagem = $e->errors("models");
            }';
            
        $controlador .= '
        }else{
            //SENAO, UPDATE
            $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).' = ORM::factory("'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'", $this->request->post("'.$carc.'_'.$id[0].'"));
            
            //SE CARREGOU O MÓDULO, FAZ O UPDATE. SENÃO, NÃO FAZ NADA
            if ($'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->loaded()){
                //ALTERA
                foreach($this->request->post() as $campo => $value){';
                
        //TESTA SE EXISTE SENHA, PARA IGNORAR O CONFIRMAR SENHA
            if(in_array("PASSWORD", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                    $controlador .= '
                    if(';
                
                $flag42 = "";
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR SENHA, ADICIONA NO IF
                    if ($post["fTipo"][$i] == "PASSWORD") {
                        $controlador .= $flag42.' $campo != "' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C"';
                        if($flag42 == ""){
                            $flag42 = " and";
                        }
                    }
                }
                
                $controlador .= '){
                ';
            }
        
        //DEFINE OS ITENS PARA ARRUMAR OS CAMPOS
            $default = '';
            $flag = "if";
            $qntCampos = 0;

            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE TIPO FOR CHAVE PRIMARIA INCREMENT, NÃO ADICIONA NO ARRAY. SE FOR IMAGEM, DEIXA ZERADO
                        if ($post["fPrimaria"][$i] != "S" and $post["fAuto"][$i] != "S") {
                            $tipo = $post['fTipo'][$i];
                            if ($tipo == "PASSWORD") {
                                $default .= '
                    '.
                    $flag.' ($campo == "' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '") {
                    //TESTA SENHA VAZIA, NAO SALVAR
                    if ($value == "") {
                        continue;
                    }
                    else {
                        if ($value == $this->request->post("' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C"))
                            $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->$campo = $value;
                    }
                }';
                                $flag = "else if";
                                $qntCampos++;
                            } else if ($tipo == "IMAGEM") {
                                $default .= '
                    '.
                    $flag . ' ($campo == "excluir'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'") {
                        $exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).' = str_replace("\'", "", $value);
                    }else if ($campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'Blob" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'x1" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'y1" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'w" or $campo == "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'h") {
                        //NÃO SALVA NO BANCO, É O CAMPO COM A IMAGEM REDIMENSIONADA
                    }';
                                $flag = "else if";
                                $qntCampos++;
                            }
                            else if ($tipo == "ARQUIVO") {
                                $default .= '
                    '.
                    $flag . ' ($campo == "excluir'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).'") {
                        $exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).' = str_replace("\'", "", $value);
                    }';
                                $flag = "else if";
                                $qntCampos++;
                            }
                        }
                    }

                    //SE ENCONTROU UM, FEZ O IF ELSE. SENÃO, TEM QUE SETAR O VALOR DEFAULT
                    if ($qntCampos > 0) {
                        $default .= 'else{ 
                        $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->$campo = $value;
                    }';
                    } else {
                        $default .= '
                    $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->$campo = $value;';
                    }

                    $controlador .= $default;
                    
                    //SE TEM SENHA, TEM QUE FECHAR O IF LÁ DE CIMA
                    if(in_array("PASSWORD", $post["fTipo"])){
                        $controlador .= '
            }';
                    }
                }
            }
            
            $controlador .= '
                }
                
                //TENTA SALVAR. SE NÃO PASSAR NA VALIDAÇÃO, VAI PRO CATCH
                try{
                    $query = $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->save();';
            
            //SE HOUVER ARQUIVO, CHECA O EXCLUIR IMAGEM E SE TEM PARA SALVAR 
            $queryExtra = "";
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                //CONTADOR DE IMAGENS
                $maxImagem = 0;
                $extraImagem = '';
                
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA OS ITENS
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        //SE NÃO FOR A PRIMEIRA IMAGEM, PRECISA DE UM NOME DIFERENTE PARA SALVAR IMAGENS DIFERENTES
                        if($maxImagem > 0){
                            $extraImagem = strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_';
                        }
                        
                        $controlador .= '
                            
                    //SE EXCLUIR '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' ESTIVER MARCADO, EXCLUI A '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'
                    if($exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).' == "on" or $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob") != ""){
                        $imgsT = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'thumb_" . $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . ".*");
                        $imgs = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'" . $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . ".*");

                        if($imgs){
                            foreach($imgs as $im){
                                unlink($im);
                            }
                        }

                        if($imgsT){
                            foreach($imgsT as $imT){
                                unlink($imT);
                            }
                        }
                    }

                    //INSERE A IMAGEM, SE EXISTIR
                    if ($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob") != "") {
                        $imgBlob = $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob");

                        if(strpos($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob"), "image/jpg") or strpos($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob"), "image/jpeg")){
                            //JPEG
                            $imgBlob = str_replace("data:image/jpeg;base64,", "", $imgBlob);
                            $ext = "jpg";
                        }else if(strpos($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob"), "image/png")){
                            //PNG
                            $imgBlob = str_replace("data:image/png;base64,", "", $imgBlob);
                            $ext = "png";
                        }

                        $imgBlob = str_replace(" ", "+", $imgBlob);
                        $data = base64_decode($imgBlob);

                        //imagem tamanho normal
                        $imgName = "'.$extraImagem.'".$'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . ".".$ext;
                        file_put_contents(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName, $data);

                        //CROP
                        if($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'w") != "" and $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'w") > 0){
                            $img = Image::factory(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                            $img = $img->crop($this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'w"), $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'h"), $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'x1"), $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'y1"))->save(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                        }

                        //thumb
                        $img = Image::factory(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                        $imgName = "'.$extraImagem.'thumb_" . $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk() . ".".$ext;
                        $img->resize(200)->save(DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$imgName);
                    }';
                        
                        //ADICIONA OS ITENS DA IMAGEM PARA COLOCAR NO IF(QUERY)
                        $queryExtra .= ' or $this->request->post("'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'Blob") != "" or $exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))));
                        
                        //INCREMENTA
                        $maxImagem++;
                    }
                }
            }
            
            //SE HOUVER ARQUIVO, CHECA O EXCLUIR ARQUIVO E SE TEM PARA SALVAR 
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA OS ITENS
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
                    //SE EXCLUIR '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).' ESTIVER MARCADO, EXCLUI O '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'
                    if($exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])))).' == "on" or $_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["name"] != ""){
                        $arq = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_" . str_replace("\'", "", $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk()) . ".*");

                        if($arq){
                            foreach($arq as $ar){
                                unlink($ar);
                            }
                        }
                    }

                    //INSERE O '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).', SE EXISTIR
                    if ($_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["name"] != "") {

                        $ext = explode(".", $_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["name"]);
                        $arqName = "'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_".str_replace("\'", "", $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->pk()) . "." . $ext[count($ext) - 1];

                        if($ext[count($ext) - 1] == "doc" or $ext[count($ext) - 1] == "docx" or $ext[count($ext) - 1] == "pdf"){
                            copy($_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["tmp_name"], DOCROOT."upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/".$arqName);
                        }
                    }';
                        
                        //ADICIONA OS ITENS DA IMAGEM PARA COLOCAR NO IF(QUERY)
                        $queryExtra .= ' or $_FILES["'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'"]["name"] != "" or $exclui'.ucwords(strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))));
                    }
                }
            }
            
            $controlador .= '
                } catch (ORM_Validation_Exception $e){
                    $query = false;
                    $mensagem = $e->errors("models");
                }
            } else{
                $query = false;
                $mensagem = "Houve um problema, nenhuma alteração realizada!";
            }';
            
            $controlador .= '
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
        if($query'.$queryExtra.'){
            $this->action_index($mensagem, false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index($mensagem, true);
        }
    }
    
    //EXCLUI REGISTRO
    public function action_excluir(){';
            
            $existe = false;
            
            //SE HOUVER HAS, ADICIONA A CONSULTA PARA EXCLUSÃO
            if (array_key_exists('fHas', $post)) {
                if (is_array($post['fHas'])) {
                    $max = count($post['fHas']);
                    
                    //LAÇO PARA ADICIONAR OS ORM
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fHas'][$i] != "") {
                            $existe = true;
                            
                            //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                            if (strpos($post["fHas"][$i], "_")) {
                                $temp = explode("_", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = "_";
                            }else if (strpos($post["fHas"][$i], " ")) {
                                $temp = explode(" ", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = " ";
                            } else {
                                $carcEst = substr($post["fHas"][$i], 0, 3);
                                $sep = " ";
                            }
                            $carcEst = strtoupper($this->trataTxt($carcEst));

                            $controlador .= '
        //VERIFICA SE EXISTEM '.strtoupper(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).' NESSA '.strtoupper($this->trataTxt($post['fTabela'])).'. SE EXISTIR, NÃO DEIXA EXCLUIR
        $'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).' = ORM::factory("'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).'")->where("'.$carc.'_ID", "=", $this->request->param("id"))->count_all();';
                        }
                    }
                    
                    if($existe){
                    $controlador .= '
                        
        if (';
                    $apelao = '';
                    $itens = '';
                    
                    //LAÇO PARA ADICIONA O IF COM TODOS OR ORMS
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fHas'][$i] != "") {
                            //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                            if (strpos($post["fHas"][$i], "_")) {
                                $temp = explode("_", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = "_";
                            }else if (strpos($post["fHas"][$i], " ")) {
                                $temp = explode(" ", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = " ";
                            } else {
                                $carcEst = substr($post["fHas"][$i], 0, 3);
                                $sep = " ";
                            }
                            $carcEst = strtoupper($this->trataTxt($carcEst));

                            $controlador .= $apelao.'$'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).' > 0';
                            
                            //ADICIONA OS ITENS
                            if($apelao != ''){
                                $itens .= ', ';
                            }
                            
                            $itens .= $post['fHas'][$i];
                        
                            $apelao = ' or ';
                        }
                    }
                    
                    //FECHA O TESTE DO IF
                    $controlador .= '){
            $this->action_index("Existem '.$itens.' cadastrados nessa '.$post['fTabela'].'! Nenhuma alteração realizada!", true);
        }else{
                        ';
                    }
                }
            }
            
            //SE HOUVER IMAGEM, FAZ EXCLUIR
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                //CONTADOR DE IMAGENS
                $maxImagem = 0;
                $extraImagem = '';
                
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        //SE NÃO FOR A PRIMEIRA IMAGEM, PRECISA DE UM NOME DIFERENTE PARA SALVAR IMAGENS DIFERENTES
                        if($maxImagem > 0){
                            $extraImagem = strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_';
                        }
                        
                        $controlador .= '
        //EXCLUI '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'
        $imgsT = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'thumb_" . $this->request->param("id") . ".*");
        $imgs = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'" . $this->request->param("id") . ".*");

        if($imgs){
            foreach($imgs as $im){
                unlink($im);
            }
        }

        if($imgsT){
            foreach($imgsT as $imT){
                unlink($imT);
            }
        }';
                        //INCREMENTA
                        $maxImagem++;
                    }
                }
            }
            
            //SE HOUVER ARQUIVO, FAZ EXCLUIR
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
        //EXCLUI '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'
        $arq = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_" . $this->request->param("id") . ".*");

        if($arq){
            foreach($arq as $ar){
                unlink($ar);
            }
        }';
                    }
                }
            }
            
            $controlador .= '
        $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).' = ORM::factory("'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'", $this->request->param("id"));
            
        //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
        if ($'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->loaded()){
            //DELETA
            $query = $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->delete();
        }else{
            $query = false;
        }
        
        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if($query){
            $this->action_index("Registro excluído com sucesso!", false);
        }else{
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("Houve um problema!", true);
        }';
            
            //SE HOUVER HAS, FECHA O ELSE
            if ($existe) {
        $controlador .= '
        }';
            }
            
            $controlador .= '
    }
    
    //EXCLUI TODOS REGISTROS MARCADOS
    public function action_excluirTodos() {
        $query = false;
        
        foreach ($this->request->post() as $value) {
            foreach($value as $val){';
            
            $existe = false;
            
            //SE HOUVER HAS, ADICIONA A CONSULTA PARA EXCLUSÃO
            if (array_key_exists('fHas', $post)) {
                if (is_array($post['fHas'])) {
                    $max = count($post['fHas']);
                    
                    //LAÇO PARA ADICIONAR OS ORM
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fHas'][$i] != "") {
                            $existe = true;
                            
                            //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                            if (strpos($post["fHas"][$i], "_")) {
                                $temp = explode("_", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = "_";
                            }else if (strpos($post["fHas"][$i], " ")) {
                                $temp = explode(" ", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = " ";
                            } else {
                                $carcEst = substr($post["fHas"][$i], 0, 3);
                                $sep = " ";
                            }
                            $carcEst = strtoupper($this->trataTxt($carcEst));

                            $controlador .= '
                //VERIFICA SE EXISTEM '.strtoupper(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).' NESSA '.strtoupper($this->trataTxt($post['fTabela'])).'. SE EXISTIR, NÃO DEIXA EXCLUIR
                $'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).' = ORM::factory("'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).'")->where("'.$carc.'_ID", "=", $this->request->param("id"))->count_all();';
                        }
                    }
                    
                    if($existe){
                    $controlador .= '
                        
                if (';
                    $apelao = '';
                    $itens = '';
                    
                    //LAÇO PARA ADICIONA O IF COM TODOS OR ORMS
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fHas'][$i] != "") {
                            //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                            if (strpos($post["fHas"][$i], "_")) {
                                $temp = explode("_", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = "_";
                            }else if (strpos($post["fHas"][$i], " ")) {
                                $temp = explode(" ", $post["fHas"][$i]);
                                $carcEst = substr($temp[0], 0, 2);
                                $carcEst .= substr($temp[1], 0, 1);
                                $sep = " ";
                            } else {
                                $carcEst = substr($post["fHas"][$i], 0, 3);
                                $sep = " ";
                            }
                            $carcEst = strtoupper($this->trataTxt($carcEst));

                            $controlador .= $apelao.'$'.strtolower(str_replace($sep, "", $this->trataTxt($post['fHas'][$i]))).' > 0';
                            
                            //ADICIONA OS ITENS
                            if($apelao != ''){
                                $itens .= ', ';
                            }
                            
                            $itens .= $post['fHas'][$i];
                        
                            $apelao = ' or ';
                        }
                    }
                    
                    //FECHA O TESTE DO IF
                    $controlador .= '){
                    $this->action_index("Existem '.$itens.' cadastrados nessa '.$post['fTabela'].'! Nenhuma alteração realizada!", true);
                    return true;
                }else{
                        ';
                    }
                }
            }
            
            //SE HOUVER IMAGEM, FAZ EXCLUIR
            if(in_array("IMAGEM", $post["fTipo"])){
                $max = count($post['fTipo']);
                
                //CONTADOR DE IMAGENS
                $maxImagem = 0;
                $extraImagem = '';
                
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR IMAGEM, ADICIONA
                    if ($post["fTipo"][$i] == "IMAGEM") {
                        
                        //SE NÃO FOR A PRIMEIRA IMAGEM, PRECISA DE UM NOME DIFERENTE PARA SALVAR IMAGENS DIFERENTES
                        if($maxImagem > 0){
                            $extraImagem = strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_';
                        }
                        
                        $controlador .= '
                //EXCLUI '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'
                $imgsT = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'thumb_" . $val . ".*");
                $imgs = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.$extraImagem.'" . $val . ".*");

                if($imgs){
                    foreach($imgs as $im){
                        unlink($im);
                    }
                }

                if($imgsT){
                    foreach($imgsT as $imT){
                        unlink($imT);
                    }
                }';
                        
                        //INCREMENTA
                        $maxImagem++;
                    }
                }
            }
            
            //SE HOUVER ARQUIVO, FAZ EXCLUIR
            if(in_array("ARQUIVO", $post["fTipo"])){
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR ARQUIVO, ADICIONA
                    if ($post["fTipo"][$i] == "ARQUIVO") {
                        $controlador .= '
                //EXCLUI '.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'
                $arq = glob("upload/'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'/'.strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).'_" . $val . ".*");

                if($arq){
                    foreach($arq as $ar){
                        unlink($ar);
                    }
                }';
                    }
                }
            }
            
            $controlador .= '
                $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).' = ORM::factory("'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'", $val);
            
                //SE CARREGOU O MÓDULO, DELETA. SENÃO, NÃO FAZ NADA
                if ($'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->loaded()){
                    //DELETA
                    $query = $'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'->delete();
                }else{
                    $query = false;
                }';
            
            //SE HOUVER HAS, FECHA O ELSE
            if ($existe) {
                $controlador .= '
                }';
            }
            
            $controlador .= '
            }
        }
        
        //SE FUNCIONOU, VOLTA PRA LISTAGEM COM MENSAGEM DE OK
        if ($query) {
            $this->action_index("Registros excluídos com sucesso!", false);
        }
        else {
            //SENAO, VOLTA COM MENSAGEM DE ERRO
            $this->action_index("Houve um problema! Nenhum registro selecionado!!", true);
        }
    }
    
    //FUNCAO DE PESQUISA
    public function action_pesquisa(){
        $this->action_index("", false);
    }

}

// End '.$post['fTabela'].'
';

            //SALVANDO
            $file = fopen($filename, "w+");
            fwrite($file, stripslashes($controlador));
            fclose($file);


            //GERA O FORMULARIO DE EDICAO
            // diretório onde encontra-se o arquivo
            $filename = $this->config["urlUpload"] . "views/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/edit.php";

//Adiciona um novo texto
            $edicao = '<section id="formulario">
    <h1>' . ucwords(str_replace("_", " ", $post['fTabela'])) . '</h1>
    <form action="<?php echo url::base() ?>' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/save" class="padrao" id="formEdit" name="formEdit" method="post"';
            
            //SE TEM ARQUIVO NO ARRAY, ADICIONA O ENCTYPE
            if(in_array("ARQUIVO", $post["fTipo"])){
                $edicao .= ' enctype="multipart/form-data" ';
            }
            
            $edicao .= '>
	
        <!--SE NECESSÁRIO, EXPLICAÇÃO-->
        <!--<p></p>-->
        <!--FORMULARIO COM INFORMACOES-->

        <input type="hidden" id="' . $carc . '_'.$id[0].'" readonly name="' . $carc . '_'.$id[0].'" value="<?php echo $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_'.$id[0].'"] ?>">
    ';

            $idImagem = false;
            
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        //SE CAMPO FOR PRIMARIO, NÃO ADICIONA, POIS JÁ FOI COLOCADO EM CIMA
                        if($post['fPrimaria'][$i] != "S"){
                            //TIPOS DE CAMPO (TEXT, STRING, SELECT...)
                            switch ($post['fTipo'][$i]) {
                                case "VARCHAR":
                                    
                                    $validar = '';
                                    
                                    if($post["fReq"][$i] == "S"){
                                        $validar = 'validar="texto"';
                                    }
                                    
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .= '
            <input type="text" '.$validar.' value="<?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"] ?>" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">';

            $edicao .= '
        </div>
                            ';
                                    break;
                                case "PASSWORD":
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .= '
            <input type="password" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"
                <?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_'.$id[0].'"] == "0"){ ?> validar="senha" <?php } ?> onchange="validaIgual(this);">';

            $edicao .= '
        </div>
        
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C">Confirmar ' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .= '
            <input type="password" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '_C"
                <?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_'.$id[0].'"] == "0"){ ?> validar="igual" validarIgual="#' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" <?php } ?>>';

            $edicao .= '
        </div>
                            ';
                                    break;
                                case "TEXT":
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .=
                    '
            <textarea class="ckeditor" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">
                <?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"] ?>
            </textarea>';

            $edicao .=
            '
        </div>
                                        ';
                                    break;
                                case "INT":
                                    //TESTA SE É CHAVE ESTRANGEIRA. SE FOR, ADICIONA O PREFIXO DA TABELA EM QUESTÃO E COLOCA COMO UM SELECT. SENÃO, INT NORMAL
                                    if($post["fRef"][$i] != ""){
                                        //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                        if (strpos($post["fRef"][$i], "_")) {
                                            $temp = explode("_", $post["fRef"][$i]);
                                            $carcEst = substr($temp[0], 0, 2);
                                            $carcEst .= substr($temp[1], 0, 1);
                                        }else if (strpos($post["fRef"][$i], " ")) {
                                            $temp = explode(" ", $post["fRef"][$i]);
                                            $carcEst = substr($temp[0], 0, 2);
                                            $carcEst .= substr($temp[1], 0, 1);
                                        } else {
                                            $carcEst = substr($post["fRef"][$i], 0, 3);
                                        }

                                        $campoTabela = strtoupper($carcEst)."_".strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                                        
                                        if($post["fRef"][$i][strlen($post["fRef"][$i])-1] == 's' or $post["fRef"][$i][strlen($post["fRef"][$i])-1] == 'S'){
                                            $tabelaRef = substr($post["fRef"][$i], 0, strlen($post["fRef"][$i])-1);
                                        }else{
                                            $tabelaRef = $post["fRef"][$i];
                                        }
                                        
                                        $validar = '';
                                    
                                        if($post["fReq"][$i] == "S"){
                                            $validar = 'validar="int"';
                                        }
                                        
                                        $edicao .=
                                    '
        <div class="item-form">
            <label for="'.$campoTabela.'">'.ucwords(($tabelaRef)).'</label>
            <select id="'.$campoTabela.'" name="'.$campoTabela.'" '.$validar.'>
                <?php foreach($'.str_replace(" ", "", strtolower($this->trataTxt($post["fRef"][$i]))).' as $'.strtolower($carcEst).'){ ?>
                <option value="<?php echo $'.strtolower($carcEst).'->'.$campoTabela.' ?>" <?php if($'.strtolower($carcEst).'->'.$campoTabela.' == (int)$'.strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))).'["'.$campoTabela.'"]) echo "selected"; ?>>
                    <?php echo $'.strtolower($carcEst).'->'.strtoupper($carcEst).'_'.strtoupper($this->trataTxt($post["fDefault"][$i])).' ?></option>
                <?php } ?>
            </select>
        </div>
                                        ';
                                    }else{
                                        
                                        $validar = '';
                                    
                                        if($post["fReq"][$i] == "S"){
                                            $validar = 'validar="int"';
                                        }
                                        
                                        $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .=
                    '
            <input type="text" '.$validar.' class="pequeno" value="<?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"] ?>" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">';

            $edicao .=
            '
        </div>
                                        ';
                                    }
                                    
                                    
                                    break;
                                case "DECIMAL":
                                    
                                    $validar = '';
                                    
                                    if($post["fReq"][$i] == "S"){
                                        $validar = 'validar="texto"';
                                    }
                                    
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .=
                    '
            <input type="text" '.$validar.' class="valor" value="<?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo number_format($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"], 2, ",", ".") ?>" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">';

            $edicao .=
            '
        </div>
                                        ';
                                    break;
                                case "DATE":
                                    
                                    $validar = '';
                                    
                                    if($post["fReq"][$i] == "S"){
                                        $validar = 'validar="data"';
                                    }
                                    
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .=
                    '
            <input type="text" '.$validar.' class="data pequeno" value="<?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo Controller_Index::aaaammdd_ddmmaaaa($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) .'"]) ?>" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">';

            $edicao .=
            '
        </div>
                                        ';
                                    break;
                                case "TIME":
                                    
                                    $validar = '';
                                    
                                    if($post["fReq"][$i] == "S"){
                                        $validar = 'validar="texto"';
                                    }
                                    
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .=
                    '
            <input type="text" '.$validar.' class="hora pequeno" value="<?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"] ?>" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">';

            $edicao .=
            '
        </div>
                                        ';
                                    break;
                                case "SET":
                                    $edicao .=
                                    '
        <div class="item-form multiplo" label="' . ucwords(($post['fCampo'][$i])) . '">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';
            
            //PARA CADA ITEM DE TAMANHO
            $itemSet = explode(",", $post['fTamanho'][$i]);
            
            foreach($itemSet as $its){
                $edicao .= '
            <input type="radio" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" <?php if ($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"] == "'.substr($its, 0, 1).'") echo "checked"; ?> id="'.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).$its.'" value="'.substr($its, 0, 1).'" validar="radio">
            <label for="'.strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))).$its.'">'.$its.'</label>';
            }

            $edicao .=
            '
        </div>
                                        ';
                                    break;
                                case "IMAGEM":
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .='
            <input type="file" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" onchange="return ShowImagePreview(this, 0, \'' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '\');">
        </div>
        
        <!--SE FOR PARA MOSTRAR PREVIEW, RETIRAR O DISPLAY NONE-->
        <div class="item-form" id="div' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'Canvas" >
            <!--<label>Preview</label>-->
            <!--PREVIEW DA IMAGEM-->
            <canvas id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'Canvas" class="previewcanvas" width="0" height="0"> ></canvas>
            <!--CAMPO HIDDEN PARA COLOCAR A IMAGEM JÁ REDIMENSIONADA-->
            <input type="hidden" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'Blob" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'Blob" />
            <input type="text" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'x1" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'x1" style="display: none;">
            <input type="text" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'y1" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'y1" style="display: none;">
            <input type="text" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'w" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'w" style="width: 50px; display: none;">
            <input type="text" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'h" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'h" style="width: 50px; display: none;">
        </div>

        <?php if($' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . ') echo $' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '; ?>
                                    ';

                                    $idImagem = strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i])));
                                    break;
                                case "ARQUIVO":
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .='
            <input type="file" id="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" >
        </div>

        <?php if($' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . ') echo $' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '; ?>
                                    ';

                                    break;
                                case "TIMESTAMP":
                                    //TIMESTAMP NÃO EDITA
                                    break;
                                default:
                                    
                                    $validar = '';
                                    
                                    if($post["fReq"][$i] == "S"){
                                        $validar = 'validar="texto"';
                                    }
                                    
                                    $edicao .=
                                    '
        <div class="item-form">
            <label for="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">' . ucwords(($post['fCampo'][$i])) . '</label>';

            $edicao .=
                    '
            <input type="text" '.$validar.' value="<?php if($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') echo $' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '["' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"] ?>" id="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" name="' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '">';

            $edicao .=
            '
        </div>
                                        ';
                                    break;
                            }
                            //FIM TIPOS DE CAMPO
                        }
                    }
                }
            }

            $edicao .=
                    '
        <div class="final">
            <button type="submit" id="salvar">Enviar</button>
            <button type="reset" id="limpa">Limpar</button>
            <p class="legenda"><em>*</em> Campos obrigatórios.</p>
        </div>
    </form>
</section>';
            
            //SE HOUVER CAMPO DE TEXTO, ADICIONA O CKFINDER
            if(in_array("TEXT", $post["fTipo"])){
                
                $edicao .= '
                    
<script type="text/javascript" src="<?php echo url::base(); ?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo url::base(); ?>js/ckfinder/ckfinder.js"></script>

<script type="text/javascript">// <![CDATA[

// This is a check for the CKEditor class. If not defined, the paths must be checked.

if ( typeof CKEDITOR == "undefined" ){

    document.write(

        "<strong><span style=\'color: #ff0000\'>Error</span>: CKEditor not found</strong>." +

        "This sample assumes that CKEditor (not included with CKFinder) is installed in" +

        "the \'/ckeditor/\' path. If you have it installed in a different place, just edit" +

        "this file, changing the wrong paths in the &lt;head&gt; (line 5) and the \'BasePath\'" +

        "value (line 32)." ) ;

}else{
';
                
                $max = count($post['fTipo']);
                for ($i = 0; $i < $max; $i++) {
                    //SE TIPO FOR TEXTO, VINCULA
                    if ($post["fTipo"][$i] == "TEXT") {
                        $edicao .= '
    var editor' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . ' = CKEDITOR.replace( "' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '" );
    CKFinder.setupCKEditor( editor' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . ', "<?php echo url::base()?>js/ckfinder/" ) ;';
                    }
                }
                
                $edicao .= '
}
// ]]>
</script>';
            }
            
            //SE HOUVER IMAGEM, ADICIONA A FUNÇÃO DE REDIMENSIONAMENTO
            if(in_array("IMAGEM", $post["fTipo"])){
                
                $edicao .= '
                    
<!--REDIMENSIONAMENTO DA IMAGEM-->
<script src="<?php echo url::base() ?>js/jcrop/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="<?php echo url::base() ?>js/jcrop/css/jquery.Jcrop.css" type="text/css" />
<script>
    var imageLoader = document.getElementById("imageLoader");
    function HandleFileEvent(event, selection, id)
    {
        var img = new Image;
        img.onload = function(event) {
            UpdatePreviewCanvas(event, img, selection, id);
        };
        img.src = event.target.result;
    }

    function ShowImagePreview(object, selection, id)
    {
        //DESTROI JCROP
        if ($("#"+id+"Blob").val() !== "") {
            $("#"+id+"Canvas").data("Jcrop").destroy();
            $("#div"+id+"Canvas").append("<canvas id=\'"+id+"Canvas\' class=\'previewcanvas\' ></canvas>");
        }
                    
        if (typeof object.files === "undefined")
            return;

        var files = object.files;

        if (!(window.File && window.FileReader && window.FileList && window.Blob))
        {
            alert("The File APIs are not fully supported in this browser.");
            return false;
        }

        if (typeof FileReader === "undefined")
        {
            alert("Filereader undefined!");
            return false;
        }

        var file = files[0];

        if (file !== undefined && file != null && !(/image/i).test(file.type))
        {
            alert("File is not an image.");
            return false;
        }

        reader = new FileReader();
        reader.onload = function(event) {
            HandleFileEvent(event, selection, id)
        }
        reader.readAsDataURL(file);
    }

    //FUNÇÃO QUE FAZ ALGUMA COISA QUE EU DESCONHEÇO, MAS POSSIVELMENTE UTIL
    function dataURItoBlob(dataURI) {
        // convert base64 to raw binary data held in a string
        // doesnt handle URLEncoded DataURIs
        var byteString;
        if (dataURI.split(",")[0].indexOf("base64") >= 0)
            byteString = atob(dataURI.split(",")[1]);
        else
            byteString = unescape(dataURI.split(",")[1]);
        // separate out the mime component
        var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

        // write the bytes of the string to an ArrayBuffer
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        // write the ArrayBuffer to a blob, and youre done
        return new Blob([ab], {type: mimeString});
    }

    function UpdatePreviewCanvas(event, img, selection, id)
    {
        var canvas = document.getElementById(id+"Canvas");
        var context = canvas.getContext("2d");
        var world = new Object();
//        world.width = canvas.offsetWidth;
//        world.height = canvas.offsetHeight;
        world.width = 1000;
        world.height = 1000;

        var WidthDif = img.width - world.width;
        var HeightDif = img.height - world.height;

        var Scale = 0.0;
        if (WidthDif > HeightDif)
        {
            Scale = world.width / img.width;
        }
        else
        {
            Scale = world.height / img.height;
        }
        if (Scale > 1)
            Scale = 1;

        var UseWidth = Math.floor(img.width * Scale);
        var UseHeight = Math.floor(img.height * Scale);
        
        canvas.width = UseWidth;
        canvas.height = UseHeight;

        var x = Math.floor((world.width - UseWidth) / 2);
        var y = Math.floor((world.height - UseHeight) / 2);

        context.drawImage(img, 0, 0, img.width, img.height, 0, 0, UseWidth, UseHeight);

        //COLOCAR DE VOLTA NO INPUT
        if($("#"+id).val().search(".jpg") > 0 || $("#"+id).val().search(".jpeg") > 0 ||
            $("#"+id).val().search(".JPG") > 0 || $("#"+id).val().search(".JPEG") > 0){
            //SEGUNDO PARAMETRO: QUALIDADE. PADRÃO DOS NAVEGADORES É 0.92
            var dataURL = canvas.toDataURL("image/jpeg", 0.92);
        }else if($("#"+id).val().search(".png") > 0 || $("#"+id).val().search(".PNG") > 0){
            var dataURL = canvas.toDataURL("image/png", 0.5);
        }else{
            alert("Formato não suportado!");
            $("#"+id).val("");
            return false;
        }

        var blob = dataURItoBlob(dataURL);

        $("#"+id+"Blob").val(dataURL);
        
        //BGCOLOR: BLACK - DEIXA FUNDO PRETO QUANDO EDITA
        //BGCOLOR: TRANSPARENT: PERMITE SALVAR PNG COM FUNDO TRANSPARENT
        ';
                
    $max = count($post['fTipo']);
    $maxImagem = 0;
    for ($i = 0; $i < $max; $i++) {
        //SE TIPO FOR IMAGEM, CRIA FUNCAO
        if ($post["fTipo"][$i] == "IMAGEM") {
            if($maxImagem > 0)  $edicao .= 'else';
            
            $edicao .= '
        if(id === "' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '"){
            var funcao = showCoords' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . ';
        }
        ';
            
            //INCREMENTA
            $maxImagem++;
        }
    }
                
                $edicao .= '
        $(canvas).Jcrop({
            bgColor: "transparent",
            bgOpacity: 0.7,
            onSelect: funcao
        });
    }';
    
    $max = count($post['fTipo']);
    for ($i = 0; $i < $max; $i++) {
        //SE TIPO FOR IMAGEM, CRIA FUNCAO
        if ($post["fTipo"][$i] == "IMAGEM") {
            $edicao .= '
    function showCoords' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '(c) {
        // variables can be accessed here as
        // c.x, c.y, c.x2, c.y2, c.w, c.h
        $("#' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'x1").val(c.x);
        $("#' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'y1").val(c.y);
        $("#' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'w").val(c.w);
        $("#' . strtolower(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . 'h").val(c.h);
    }';
        }
    }
    
    $edicao .= '
</script>';
            }
            
            //SE TIVER SENHA, ADICIONAR O SCRIPT PARA VALIDAR CONFIRMAÇÃO DE SENHA
            if(in_array("PASSWORD", $post["fTipo"])){
                        $edicao .= '
                            
<script type="text/javascript">
    function validaIgual(valor){
        if($(valor).val().length > 0){
            $("#"+valor.id).attr("validar", "senha");
            $("#"+valor.id+"_C").attr("validar", "igual");
            $("#"+valor.id+"_C").attr("validarIgual", "#"+valor.id);
        }else{
            $("#"+valor.id).removeAttr("validar");
            $("#"+valor.id+"_C").removeAttr("validar");
            $("#"+valor.id+"_C").removeAttr("validarIgual");
        }
    }
</script>
';
            }

            //SALVANDO
            $file = fopen($filename, "w+");
            fwrite($file, stripslashes($edicao));
            fclose($file);


            //GERA A LISTAGEM
            // diretório onde encontra-se o arquivo
            $filename = $this->config["urlUpload"] . "views/" . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . "/list.php";

//Adciona um novo texto
            $listagem = '<section id="lista">
    <h1>' . ucwords(str_replace("_", " ", $post['fTabela'])) . '</h1>
    
    <!--MENSAGEM DE INCLUSAO, ALTERACAO OU EXCLUSAO-->
    <?php if($mensagem != ""){ ?>
    <p><?php echo $mensagem ?></p>
    <?php } ?>
    
    <!--INCLUIR E PESQUISA-->
    <div class="operacoes">
        <a href="<?php echo url::base() ?>' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/edit" class="btn-inserir">Inserir</a>

        <form id="formBusca" name="formBusca" method="get" action="<?php echo url::base() ?>' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/pesquisa" class="pesquisa">
            <label for="chave">Pesquise um registro:</label>
            <input type="search" id="chave" name="chave" placeholder="Busca" />
            <button type="submit">Buscar</button>
        </form>
    </div>
    
    <!--LISTA DE REGISTROS-->
    <table class="padrao">
        <colgroup>
            <col class="box">
            <col class="codigo direita">';
            $cont = 3;

            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fPesquisar'][$i] == "S" or $post['fRef'][$i] != "") {
                            $cont++;
                            $listagem .= '
            <col>';
                        }
                    }
                }
            }

            $listagem .= '
            <col class="acoes">
        </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" class="seleciona" onclick="selecionar(this.checked)" valor="0"></th>
                <th class="codigo direita">Código</th>';
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fPesquisar'][$i] == "S" or $post['fRef'][$i] != "") {
                            if($post['fRef'][$i] != ""){
                                $listagem .= '
                <th>' . ucwords(($post['fRef'][$i])) . '</th>';
                            }else{
                                $listagem .= '
                <th>' . ucwords(($post['fCampo'][$i])) . '</th>';
                            }
                        }
                    }
                }
            }
            $listagem .= '
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            //SE TEM CADASTRADO, MOSTRA. SENÃO, MOSTRA O AVISO
            if (count($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ') > 0) {
                foreach($' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . ' as $' . strtolower($carc) . '){
                    ?>
                    <tr>
                        <td><input type="checkbox" class="seleciona" valor="<?php echo $' . strtolower($carc) . '->' . $carc . '_'.$id[0].'; ?>"></td>
                        <td class="codigo direita"><?php echo $' . strtolower($carc) . '->' . $carc . '_'.$id[0].'; ?></td>';
            if (array_key_exists('fCampo', $post)) {
                if (is_array($post['fCampo'])) {
                    $max = count($post['fCampo']);
                    for ($i = 0; $i < $max; $i++) {
                        if ($post['fPesquisar'][$i] == "S" or $post['fRef'][$i] != "") {
                            if($post['fRef'][$i] != ""){
                                //PEGA OS 3 PRIMEIROS CARACTERES DESSA TABELA
                                if (strpos($post["fRef"][$i], "_")) {
                                    $temp = explode("_", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                    $sep = "_";
                                }else if (strpos($post["fRef"][$i], " ")) {
                                    $temp = explode(" ", $post["fRef"][$i]);
                                    $carcEst = substr($temp[0], 0, 2);
                                    $carcEst .= substr($temp[1], 0, 1);
                                    $sep = " ";
                                } else {
                                    $carcEst = substr($post["fRef"][$i], 0, 3);
                                    $sep = " ";
                                }
                                $carcEst = strtoupper($carcEst);
                                
                                $listagem .= '
                        <td><?php echo $' . strtolower($carc) . '->'. strtolower(str_replace($sep, "", $this->trataTxt($post['fRef'][$i]))). '->' . $carcEst . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fDefault'][$i]))) . '; ?></td>';
                            }else{
                                //SE FOR DATA, INVERTE
                                if($post['fTipo'][$i] == "DATE"){
                                $listagem .= '
                        <td><?php echo Controller_Index::aaaammdd_ddmmaaaa($' . strtolower($carc) . '->' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '); ?></td>';
                                }else{
                                $listagem .= '
                        <td><?php echo $' . strtolower($carc) . '->' . $carc . '_' . strtoupper(str_replace(" ", "_", $this->trataTxt($post['fCampo'][$i]))) . '; ?></td>';
                                }
                            }
                        }
                    }
                }
            }
            $listagem .= '
                        <td>
                            <a href="<?php echo url::base() ?>' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/edit/<?php echo $' . strtolower($carc) . '->' . $carc . '_'.$id[0].'; ?>" 
                                class="btn-editar"></a>
                            <a onclick="
                                if (window.confirm(\'Deseja realmente excluir o registro?\')) {
                                    location.href = \'<?php echo url::base() ?>' . strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela']))) . '/excluir/<?php echo 
                                        $' . strtolower($carc) . '->' . $carc . '_'.$id[0].'; ?>\';
                                }    
                               " class="btn-excluir">
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            else {
                ?>
                <tr>
                    <td colspan="' . $cont . '" class="naoEncontrado">';
            if (strtolower($tabela[strlen($tabela) - 1]) == "a") {
                $listagem .= 'Nenhuma ';
            } else {
                $listagem .= 'Nenhum ';
            }
            $listagem .= ucwords(strtolower(str_replace("_", " ", $post['fTabela'])));
            if (strtolower($tabela[strlen($tabela) - 1]) == "a") {
                $listagem .= ' encontrada';
            } else {
                $listagem .= ' encontrado';
            }
            $listagem .= '</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    
    <!--EXCLUI TODOS MARCADOS-->
    <div class="operacoes">
        <a onclick="
            if (window.confirm(\'Deseja realmente excluir os registros marcados?\')) {
                excluirTodos(\'<?php echo Request::current()->controller(); ?>\');
            }
           " class="btn-excluir-todos">Excluir todos marcados</a>
    </div>

    <!--PAGINACAO-->
    <?php echo $pagination; ?>
</section>

<!--ONDE MONTA O FORMULARIO PARA EXCLUIR OS MARCADOS-->
<div id="formExc"></div>
';

            //SALVANDO
            $file = fopen($filename, "w+");
            fwrite($file, stripslashes($listagem));
            fclose($file);
            
            //ADICIONA O MÓDULO NO BANCO
            $idModulo = Database::instance()->query(Database::INSERT, "INSERT IGNORE INTO `MODULOS` (`MOD_NOME`, `MOD_LINK`, `MOD_ICONE`, `CAM_ID`) VALUES 
                ('".ucwords($post['fTabela'])."', '".strtolower(str_replace($separador, "", $this->trataTxt($post['fTabela'])))."', '', 1)"
                    . " ON DUPLICATE KEY UPDATE MOD_NOME = '".ucwords($post['fTabela'])."';");
            
            //ADICIONA PERMISSÃO NESSE MÓDULO
            Database::instance()->query(Database::INSERT, "INSERT IGNORE INTO `MODULOS_PERMISSOES` (`MOD_ID`, `PER_ID`) VALUES 
                (".$idModulo[0].", 1) ON DUPLICATE KEY UPDATE MOD_ID = MOD_ID;");
            
            return true;
    }
    
    //Take some caracters out
    protected static function trataTxt($var) {
        //return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($var));
        $trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
	$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
	$titletext = str_replace($trocarIsso, $porIsso, $var);
        return $titletext;
    }
}

// End Gerador