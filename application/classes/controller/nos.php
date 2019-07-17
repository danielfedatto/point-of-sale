<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Nos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Nós";
        
    }

    public function action_index() {
        $view = View::Factory("nos");
        
        //BUSCA OS REGISTROS        
        $view->nos = ORM::factory("nos")->find();
        $view->servicos = ORM::factory("servicos")->find_all();
        $view->equipe = ORM::factory("equipe")->find_all();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>