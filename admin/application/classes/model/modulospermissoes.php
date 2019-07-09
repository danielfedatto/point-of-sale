<?php

defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Modulospermissoes extends ORM {

    protected $_table_name = 'MODULOS_PERMISSOES';
    protected $_primary_key = array('MOD_ID', 'PER_ID');
    protected $_sorting = array('MOD_ID' => 'asc');

    //RELATIONSHIP
    protected $_belongs_to = array(
        'permissoes' => array(
            'model'       => 'permissoes',
            'foreign_key' => 'PER_ID',
        ),
        'modulos' => array(
            'model'       => 'modulos',
            'foreign_key' => 'MOD_ID',
        )
    );
    
    public function __construct($id = NULL) {
        parent::__construct($id);
    }
}
