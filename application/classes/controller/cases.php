<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Cases extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Cases";
        
    }

    public function action_index() {
        $view = View::Factory("cases");
        
        //BUSCA OS REGISTROS        
        $view->cases = ORM::factory("cases")->order_by(DB::expr('RAND()'))->find_all();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>