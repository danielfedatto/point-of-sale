<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Equipe extends ORM {

    protected $_table_name = "EQUIPE";
    protected $_primary_key = "EQU_ID";
        protected $_sorting = array("EQU_ID" => "asc");
    
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
            "EQU_NOME" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "EQU_ORDEM" => array(
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS EQUIPE (
            EQU_ID INT (11) unsigned NOT NULL auto_increment,
            EQU_NOME VARCHAR (250) NOT NULL ,
            EQU_CARGO VARCHAR (250) NULL ,
            EQU_ORDEM INT (11) NOT NULL  default '0',
            PRIMARY KEY  (EQU_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
