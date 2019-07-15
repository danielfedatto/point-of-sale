<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Configuracoes extends ORM {

    protected $_table_name = "CONFIGURACOES";
    protected $_primary_key = "CON_ID";
        protected $_sorting = array("CON_ID" => "asc");
    
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
            "CON_EMPRESA" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 250)),
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS CONFIGURACOES (
            CON_ID INT (11) unsigned NOT NULL auto_increment,
            CON_EMPRESA VARCHAR (250) NOT NULL ,
            CON_KEYWORDS TEXT  NULL ,
            CON_DESCRIPTION TEXT  NULL ,
            CON_GOOGLE_ANALYTICS TEXT  NULL ,
            CON_FACEBOOK VARCHAR (250) NULL ,
            CON_INSTAGRAM VARCHAR (250) NULL ,
            CON_PINTREST VARCHAR (250) NULL ,
            CON_BEHANCE VARCHAR (250) NULL ,
            CON_ENDERECO TEXT  NULL ,
            CON_EMAIL VARCHAR (250) NOT NULL ,
            CON_TELEFONE VARCHAR (250) NULL ,
            CON_HORARIO_ATENDIMENTO TEXT  NULL ,
            PRIMARY KEY  (CON_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
