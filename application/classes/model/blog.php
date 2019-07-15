<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Blog extends ORM {

    protected $_table_name = "BLOG";
    protected $_primary_key = "BLO_ID";
        protected $_sorting = array("BLO_ID" => "asc");
    
    //RELATIONSHIP
    protected $_belongs_to = array(
        "usuarios" => array(
            "model"       => "usuarios",
            "foreign_key" => "USU_ID",
        ),
    );
    protected $_has_many = array(
        "blogcategorias" => array(
            "model"       => "blogcategorias",
            "foreign_key" => "BLO_ID",
        ),
    );
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            "BLO_TITULO" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "BLO_TEXTO" => array(
                array("not_empty"),
            ),
            "USU_ID" => array(
                array("not_empty"),
                array(array($this, "existsUsu")),
            ),
        );
    }
    
    //FILTROS
    public function filters(){
        return array(
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS BLOG (
            BLO_ID INT (11) unsigned NOT NULL auto_increment,
            BLO_TITULO VARCHAR (250) NOT NULL ,
            BLO_DATA_E_HORA TIMESTAMP  NOT NULL  default CURRENT_TIMESTAMP,
            BLO_TEXTO TEXT  NOT NULL ,
            USU_ID INT (11) unsigned NOT NULL ,
            PRIMARY KEY  (BLO_ID),
            FOREIGN KEY (USU_ID) REFERENCES USUARIOS(USU_ID) ON DELETE RESTRICT ON UPDATE RESTRICT
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
                        
    //CHECA SE A USUARIOS EXISTE
    public static function existsUsu($id) {
        $results = DB::select("*")->from("USUARIOS")->where("USU_ID", "=", $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
}
