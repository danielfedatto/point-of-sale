<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Quemsomos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Quem somos";
        
    }

    public function action_index() {
        $view = View::Factory("quemsomos");
        
        //BUSCA OS REGISTROS        
        $view->quemsomos = ORM::factory("quemsomos")->find();
        $view->timetexto = ORM::factory("timetexto")->find();
        $view->time = ORM::factory("time")->find_all();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>