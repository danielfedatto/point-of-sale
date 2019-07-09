<?php

defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Modulos extends ORM {

    protected $_table_name = 'MODULOS';
    protected $_primary_key = 'MOD_ID';
    protected $_sorting = array('MOD_NOME' => 'asc');
    
    //RELATIONSHIP
    protected $_belongs_to = array(
        'categoriamodulo' => array(
            'model'       => 'categoriamodulo',
            'foreign_key' => 'CAM_ID',
        ),
    );
    protected $_has_many = array(
        'modulospermissoes' => array(
            'model'       => 'modulospermissoes',
            'foreign_key' => 'MOD_ID'
        ),
        'modulosfavoritos' => array(
            'model'       => 'modulosfavoritos',
            'foreign_key' => 'MOD_ID'
        )
    );

    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            'MOD_NOME' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 64))
            ), //Standard, build into Kohana validation library
            'MOD_LINK' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 64)),
            ),
            'CAM_ID' => array(
                array('not_empty'),
                array(array($this, 'exists'))
            )
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS MODULOS (
            MOD_ID int(11) unsigned NOT NULL auto_increment,
            MOD_NOME varchar(64) NOT NULL default '',
            MOD_LINK varchar(64) NOT NULL default '',
            MOD_ICONE varchar(20) NOT NULL,
            CAM_ID int(11) unsigned NOT NULL,
            PRIMARY KEY  (MOD_ID),
            UNIQUE KEY MOD_LINK (MOD_LINK),
            CONSTRAINT fk_moduloscam FOREIGN KEY (CAM_ID) REFERENCES CATEGORIA_MODULO(CAM_ID) ON DELETE RESTRICT ON UPDATE RESTRICT
          ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
        
        parent::__construct($id);
    }
    
    //CHECA SE A CATEGORIA EXISTE
    public static function exists($id) {
        $results = DB::select('*')->from("CATEGORIA_MODULO")->where("CAM_ID", '=', $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }

}
