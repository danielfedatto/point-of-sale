<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Gerador extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Gerador";
        
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index($mensagem = "", $erro = false) {
        //INSTANCIA A VIEW DE LISTAGEM POR DEFAULT
        $view = View::Factory('gerador');
        
        $view->gerador = Gerador::factory(array(
            'urlForm' => url::base().'gerador/salvar',
            'urlUpload' => getcwd().'/application/'
        ));

        $this->template->conteudo = $view;
    }
    
    public function action_salvar() {
        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
            
            //CRIA O MODULO
            $gerador = Gerador::factory(array(
                'urlForm' => url::base().'gerador/salvar',
                'urlUpload' => getcwd().'/application/'
            ));
            
            //CREATE THE FILES
            $gerador->salvar($this->request->post());
            
            echo json_encode(array("ok" => "OK"));
        }        
    }
}

// End Empresa