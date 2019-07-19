<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Artigos extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Artigos";
        
    }

    public function action_index() {

    }

    public function action_ver() {
        $view = View::Factory("artigos");
        
        $id = $this->request->param("id");
        $this->template->titulo .= ' - '.urldecode($this->request->param("titulo"));
        
        //BUSCA OS REGISTROS        
        $view->artigo = ORM::factory("artigos")->where("ART_ID", "=", $id)->find();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>