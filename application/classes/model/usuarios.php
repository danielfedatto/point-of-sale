<?php

defined('SYSPATH') OR die('No Direct Script Access');

Class Model_Usuarios extends ORM {

    protected $_table_name = 'USUARIOS';
    protected $_primary_key = 'USU_ID';
    protected $_sorting = array('USU_NOME' => 'asc');
    
    //RELATIONSHIP
    protected $_belongs_to = array(
        'permissoes' => array(
            'model'       => 'permissoes',
            'foreign_key' => 'PER_ID',
        ),
    );
    protected $_has_many = array(
        'modulosfavoritos' => array(
            'model'       => 'modulosfavoritos',
            'foreign_key' => 'USU_ID'
        )
    );
    
    //REGRAS DE VALIDAÇÃO
    //Define all validations our model must pass before being saved
    //Notice how the errors defined here correspond to the errors defined in our Messages file
    public function rules() {
        return array(
            'USU_NOME' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 100))
            ), //Standard, build into Kohana validation library
            'USU_EMAIL' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 200)),
            ),
            'USU_LOGIN' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 50)),
            ),
            'USU_DATA_CADASTRO' => array(
                array('not_empty')
            ),
            'PER_ID' => array(
                array('not_empty'),
                array(array($this, 'exists'))
            )
        );
    }
    
    //FILTROS
    public function filters(){
        return array(
            'USU_DATA_CADASTRO' => array(
                array(array($this, 'arrumaData')),
            ),
            'USU_SENHA' => array(
                array(array($this, 'criptografaSenha')),
            ),
        );
    }

    public function __construct($id = NULL) {
        //GERA A TABELA
        Database::instance()->query(Database::INSERT, "CREATE TABLE IF NOT EXISTS USUARIOS (
            USU_ID int(11) unsigned NOT NULL auto_increment,
            PER_ID int(11) unsigned NOT NULL,
            USU_NOME varchar(100) NOT NULL,
            USU_EMAIL varchar(200) NOT NULL default '',
            USU_LOGIN varchar(50) NOT NULL,
            USU_SENHA varchar(32) NOT NULL,
            USU_DATA_CADASTRO date NOT NULL default '0000-00-00',
            PRIMARY KEY  (USU_ID),
            UNIQUE KEY USU_LOGIN (USU_LOGIN),
            CONSTRAINT fk_usuariosper FOREIGN KEY (PER_ID) REFERENCES PERMISSOES(PER_ID) ON DELETE RESTRICT ON UPDATE RESTRICT
          ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
        
        parent::__construct($id);
    }
    
    //CHECA SE A PERMISSAO EXISTE
    public static function exists($id) {
        $results = DB::select('*')->from("PERMISSOES")->where("PER_ID", '=', $id)->execute()->as_array();
        if(count($results) == 0)
            return false;
        else
            return true;
    }
}
