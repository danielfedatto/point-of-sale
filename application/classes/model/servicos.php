<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Servicos extends ORM {

    protected $_table_name = "SERVICOS";
    protected $_primary_key = "SER_ID";
        protected $_sorting = array("SER_ORDEM" => "asc");
    
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
            "SER_TITULO" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "SER_ORDEM" => array(
                array("not_empty"),
            ),
            "SER_TEXTO" => array(
                array("not_empty"),
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS SERVICOS (
            SER_ID INT (11) unsigned NOT NULL auto_increment,
            SER_TITULO VARCHAR (250) NOT NULL ,
            SER_ORDEM INT (11) NOT NULL  default '0',
            SER_TEXTO TEXT  NOT NULL ,
            PRIMARY KEY  (SER_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
