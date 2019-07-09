<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Categoriamodulo extends ORM {

    protected $_table_name = "CATEGORIA_MODULO";
    protected $_primary_key = "CAM_ID";
    protected $_sorting = array("CAM_ORDEM" => "ASC");
    
    //RELATIONSHIP
    protected $_belongs_to = array(
    );
    protected $_has_many = array(
        "modulos" => array(
            "model"       => "modulos",
            "foreign_key" => "CAM_ID",
        ),
    );
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            "CAM_NOME" => array(
                array("not_empty"),
                array("min_length", array(":value", 3)),
                array("max_length", array(":value", 50)),
            ),
            "CAM_ORDEM" => array(
                array("not_empty"),
                array("min_length", array(":value", 1)),
                array("max_length", array(":value", 11)),
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS CATEGORIA_MODULO (
            CAM_ID INT (11) unsigned NOT NULL auto_increment,
            CAM_NOME VARCHAR (50) NOT NULL,
            CAM_ORDEM int(11) NOT NULL,
            PRIMARY KEY  (CAM_ID)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
}
