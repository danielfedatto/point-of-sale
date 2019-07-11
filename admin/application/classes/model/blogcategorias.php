<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Blogcategorias extends ORM {

    protected $_table_name = "BLOG_CATEGORIAS";
    protected $_primary_key = "BLC_ID";
        protected $_sorting = array("BLC_ID" => "asc");
    
    //RELATIONSHIP
    protected $_belongs_to = array(
        "blog" => array(
            "model"       => "blog",
            "foreign_key" => "BLO_ID",
        ),
        "categorias" => array(
            "model"       => "categorias",
            "foreign_key" => "CAT_ID",
        ),
    );
    protected $_has_many = array(
    );
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            "BLO_ID" => array(
                array("not_empty"),
                array(array($this, "existsBlo")),
            ),
            "CAT_ID" => array(
                array("not_empty"),
                array(array($this, "existsCat")),
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS BLOG_CATEGORIAS (
            BLC_ID INT (11) unsigned NOT NULL auto_increment,
            BLO_ID INT (11) unsigned NOT NULL ,
            CAT_ID INT (11) unsigned NOT NULL ,
            PRIMARY KEY  (BLC_ID),
            FOREIGN KEY (BLO_ID) REFERENCES BLOG(BLO_ID) ON DELETE RESTRICT ON UPDATE RESTRICT,
            FOREIGN KEY (CAT_ID) REFERENCES CATEGORIAS(CAT_ID) ON DELETE RESTRICT ON UPDATE RESTRICT
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
                        
    //CHECA SE A BLOG EXISTE
    public static function existsBlo($id) {
        $results = DB::select("*")->from("BLOG")->where("BLO_ID", "=", $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
                        
    //CHECA SE A CATEGORIAS EXISTE
    public static function existsCat($id) {
        $results = DB::select("*")->from("CATEGORIAS")->where("CAT_ID", "=", $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
}
