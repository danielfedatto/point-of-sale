<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Post extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Blog";
        
    }

    public function action_index() {

    }

    public function action_ver() {
        $view = View::Factory("post");
        
        $id = $this->request->param("id");
        $this->template->titulo .= ' - '.urldecode($this->request->param("titulo"));
        
        //BUSCA OS REGISTROS        
        $view->blog = ORM::factory("blog")->with("usuarios")->where("BLO_ID", "=", $id)->find();
        $view->blogcategorias = ORM::factory("blogcategorias")->with("categorias")->where("BLO_ID", "=", $id)->find_all();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>