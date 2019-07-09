<?php

defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Acessos extends ORM {

    protected $_table_name = 'ACESSOS';
    protected $_primary_key = 'ACE_ID';
    protected $_sorting = array('ACE_DATA' => 'desc', 'ACE_HORA' => 'desc');
    
    protected $_belongs_to = array(
            'usuarios' => array(
            'model'       => 'usuarios',
            'foreign_key' => 'USU_ID',
        ),
    );
    
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            'ACE_IP' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 20))
            ), //Standard, build into Kohana validation library
            'ACE_DATA' => array(
                array('not_empty')
            ),
            'ACE_HORA' => array(
                array('not_empty')
            ),
            'ACE_MODULO' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 50))
            ),
            'USU_ID' => array(
                array('not_empty'),
                array(array($this, 'exists'))
            )
        );
    }
    
    //FILTROS
    public function filters(){
        return array(
            'ACE_DATA' => array(
                array(array($this, 'arrumaData')),
            )
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS `ACESSOS` (
  `ACE_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ACE_IP` varchar(20) NOT NULL,
  `ACE_DATA` date NOT NULL,
  `ACE_HORA` time NOT NULL,
  `ACE_MODULO` varchar(50) NOT NULL,
  `ACE_ACAO` varchar(50) NOT NULL,
  `ACE_ITEM` int(11) NOT NULL,
  `ACE_POST` TEXT NOT NULL,
  `USU_ID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ACE_ID`),
  CONSTRAINT fk_acessosusu FOREIGN KEY (USU_ID) REFERENCES USUARIOS(USU_ID) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
        
        parent::__construct($id);
    }
    
    
    
    //CHECA SE O USUARIO EXISTE
    public static function exists($id) {
        $results = DB::select('*')->from("USUARIOS")->where("USU_ID", '=', $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
}
