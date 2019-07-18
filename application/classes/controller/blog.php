<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Blog extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Blog";
        
    }

    public function action_index() {
        $view = View::Factory("blog");
        
        //BUSCA OS REGISTROS        
        $blog = ORM::factory("blog")->with("usuarios");

        //PAGINAÇÃO
        $paginas = $this->action_page($blog, 6);
        $view->blog = $paginas["data"];
        $view->pagination = $paginas["pagination"];
        
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>