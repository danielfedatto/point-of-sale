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

    public function action_autor() {
        $view = View::Factory("blog");
        
        $id = $this->request->param("id");

        //BUSCA OS REGISTROS        
        $blog = ORM::factory("blog")->with("usuarios")->where("blog.USU_ID", "=", $id);

        //PAGINAÇÃO
        $paginas = $this->action_page($blog, 6);
        $view->blog = $paginas["data"];
        $view->pagination = $paginas["pagination"];
        
        
        $this->template->conteudo = $view;
    }

    public function action_categoria() {
        $view = View::Factory("blog");
        
        $id = $this->request->param("id");
        $this->template->titulo .= ' - '.urldecode($this->request->param("titulo"));

        //BUSCA OS REGISTROS        
        $blog = ORM::factory("blog")->with("blogcategorias")->with("usuarios")
                            ->where("blogcategorias.CAT_ID", "=", $id);

        //PAGINAÇÃO
        $paginas = $this->action_page($blog, 6);
        $view->blog = $paginas["data"];
        $view->pagination = $paginas["pagination"];
        
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>