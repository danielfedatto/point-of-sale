<?php

defined("SYSPATH") OR die("No Direct Script Access");

Class Model_Servicoscases extends ORM {

    protected $_table_name = "SERVICOS_CASES";
    protected $_primary_key = "SEC_ID";
        protected $_sorting = array("SEC_ID" => "asc");
    
    //RELATIONSHIP
    protected $_belongs_to = array(
        "cases" => array(
            "model"       => "cases",
            "foreign_key" => "CAS_ID",
        ),
        "servicos" => array(
            "model"       => "servicos",
            "foreign_key" => "SER_ID",
        ),
    );
    protected $_has_many = array(
    );
                
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            "CAS_ID" => array(
                array("not_empty"),
                array(array($this, "existsCas")),
            ),
            "SER_ID" => array(
                array("not_empty"),
                array(array($this, "existsSer")),
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
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS SERVICOS_CASES (
            SEC_ID INT (11) unsigned NOT NULL auto_increment,
            CAS_ID INT (11) unsigned NOT NULL ,
            SER_ID INT (11) unsigned NOT NULL ,
            PRIMARY KEY  (SEC_ID),
            FOREIGN KEY (CAS_ID) REFERENCES CASES(CAS_ID) ON DELETE RESTRICT ON UPDATE RESTRICT,
            FOREIGN KEY (SER_ID) REFERENCES SERVICOS(SER_ID) ON DELETE RESTRICT ON UPDATE RESTRICT
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
                        
    //CHECA SE A CASES EXISTE
    public static function existsCas($id) {
        $results = DB::select("*")->from("CASES")->where("CAS_ID", "=", $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
                        
    //CHECA SE A SERVICOS EXISTE
    public static function existsSer($id) {
        $results = DB::select("*")->from("SERVICOS")->where("SER_ID", "=", $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
}
