<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Artigos extends ORM {

    protected $_table_name = "ARTIGOS";
    protected $_primary_key = "ART_ID";
        protected $_sorting = array("ART_DATA" => "desc");
    
    //RELATIONSHIP
    protected $_belongs_to = array(
    );
    protected $_has_many = array(
    );
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            "ART_TITULO" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "ART_TEXTO" => array(
                array("not_empty"),
            ),
            "ART_DATA" => array(
                array("not_empty"),
            ),
        );
    }
    
    //FILTROS
    public function filters(){
        return array(
            "ART_DATA" => array(
                array(array($this, "arrumaData")),
            ),
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS ARTIGOS (
            ART_ID INT (11) unsigned NOT NULL auto_increment,
            ART_TITULO VARCHAR (250) NOT NULL ,
            ART_TEXTO TEXT  NOT NULL ,
            ART_DATA DATE  NOT NULL ,
            PRIMARY KEY  (ART_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
