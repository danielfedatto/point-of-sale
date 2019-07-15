<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Contatos extends ORM {

    protected $_table_name = "CONTATOS";
    protected $_primary_key = "CON_ID";
        protected $_sorting = array("CON_DATA" => "desc");
    
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
            "CON_DATA" => array(
                array("not_empty"),
            ),
            "CON_NOME" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "CON_EMAIL" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
            ),
            "CON_FONE" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 50)),
            ),
            "CON_MENSAGEM" => array(
                array("not_empty"),
            ),
        );
    }
    
    //FILTROS
    public function filters(){
        return array(
            "CON_DATA" => array(
                array(array($this, "arrumaData")),
            ),
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS CONTATOS (
            CON_ID INT (11) unsigned NOT NULL auto_increment,
            CON_DATA DATE  NOT NULL ,
            CON_NOME VARCHAR (250) NOT NULL ,
            CON_EMAIL VARCHAR (250) NOT NULL ,
            CON_FONE VARCHAR (50) NOT NULL ,
            CON_MENSAGEM TEXT  NOT NULL ,
            PRIMARY KEY  (CON_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
