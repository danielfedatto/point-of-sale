<?php

defined("SYSPATH") or die("No direct script access.");

class Controller_Caseinterna extends Controller_Index {

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo .= " - Cases";
        
    }

    public function action_index() {
        $view = View::Factory("caseinterna");
        
        $id = $this->request->param("id");
        $this->template->titulo .= " - ".urldecode($this->request->param("titulo"));

        //BUSCA OS REGISTROS DE CASES       
        $view->case = ORM::factory("cases")->where("CAS_ID", "=", $id)->find();

        $view->servicos = ORM::factory("servicos")->with("servicoscases")
                            ->where("servicoscases.CAS_ID", "=", $id)
                            ->find_all();

        $view->relacionados = ORM::factory("cases")->with("servicoscases")
                            ->and_where_open();
                            foreach($view->servicos as $ser){
                                $view->relacionados->or_where("servicoscases.SER_ID", "=", $ser->SER_ID);
                            }
                            $view->relacionados = $view->relacionados->and_where_close()
                            ->where("cases.CAS_ID", "!=", $id)
                            ->group_by('cases.CAS_ID')
                            ->order_by('cases.CAS_ID', 'DESC')
                            ->limit(4)
                            ->find_all();
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>