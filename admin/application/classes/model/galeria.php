<?php

defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Galeria extends ORM {

    protected $_table_name = 'GALERIA';
    protected $_primary_key = 'GAL_ID';
    protected $_sorting = array('GAL_ORDEM' => 'asc');

    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            'GAL_IMAGEM' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 50))
            ),
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS GALERIA (
            GAL_ID int(11) unsigned NOT NULL auto_increment,
            GAL_IMAGEM varchar(50) NOT NULL,
            GAL_LEGENDA varchar(250) NOT NULL,
            GAL_ORDEM varchar(250) NOT NULL,
            PRIMARY KEY  (GAL_ID)
          ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
        
        parent::__construct($id);
    }

}
