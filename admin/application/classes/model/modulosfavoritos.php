<?php

defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Modulosfavoritos extends ORM {

    protected $_table_name = 'MODULOS_FAVORITOS';
    protected $_primary_key = array('MOD_ID', 'USU_ID');
    protected $_sorting = array('MOD_ID' => 'asc');

    //RELATIONSHIP
    protected $_belongs_to = array(
        'usuarios' => array(
            'model'       => 'usuarios',
            'foreign_key' => 'USU_ID',
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
