<?php defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Permissoes extends ORM
{
    protected $_table_name = 'PERMISSOES';
    protected $_primary_key = 'PER_ID';
    protected $_sorting = array('PER_NOME' => 'asc');
    
    //RELATIONSHIP
    protected $_has_many = array(
        'usuarios' => array(
            'model'       => 'usuarios',
            'foreign_key' => 'PER_ID',
        ),
        'modulospermissoes' => array(
            'model'       => 'modulospermissoes',
            'foreign_key' => 'PER_ID',
        )
    );
    
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            'PER_NOME' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 48))
            )
        );
    }
    
    public function __construct($id = NULL){
        //GERA AS TABELAS
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS PERMISSOES (
            PER_ID int(11) unsigned NOT NULL auto_increment,
            PER_NOME varchar(48) NOT NULL default '',
            PRIMARY KEY  (PER_ID)
          ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
        
        parent::__construct($id);
    }
}
