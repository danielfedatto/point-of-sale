<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Cases extends ORM {

    protected $_table_name = "CASES";
    protected $_primary_key = "CAS_ID";
        protected $_sorting = array("CAS_ID" => "asc");
    
    //RELATIONSHIP
    protected $_belongs_to = array(
    );
    
    protected $_has_many = array(
        "servicoscases" => array(
            "model"       => "servicoscases",
            "foreign_key" => "CAS_ID",
        ),
    );
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            "CAS_TITULO" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "CAS_TEXTO" => array(
                array("not_empty"),
            ),
            "CAS_HOME" => array(
                array("not_empty"),
                array(array($this, "valorSN")),
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS CASES (
            CAS_ID INT (11) unsigned NOT NULL auto_increment,
            CAS_TITULO VARCHAR (250) NOT NULL ,
            CAS_TEXTO TEXT  NOT NULL ,
            CAS_HOME SET ('S','N') NOT NULL  default 'S',
            PRIMARY KEY  (CAS_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
