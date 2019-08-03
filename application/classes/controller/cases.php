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

    public function action_servicos() {
        $view = View::Factory("cases");

        $id = $this->request->param("id");
        $this->template->titulo .= ' - '.urldecode($this->request->param("titulo"));
        
        //BUSCA OS REGISTROS        
        $view->cases = ORM::factory("cases")
                            ->with("servicoscases")
                            ->where("SER_ID", "=", $id)
                            ->group_by('cases.CAS_ID')
                            ->order_by(DB::expr('RAND()'))
                            ->find_all();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>