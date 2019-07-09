<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Template {

    public $template = 'error';
    public $gravar_logs = TRUE;
    public $empresa = "Sistema2015";

    public function before() {
        parent::before();
        $this->_name = $this->request->controller();
        $this->template->titulo = $this->empresa . " - ERROR 404";

        if ($this->request->is_ajax()) {
            $this->auto_render = FALSE;
        }
    }

    public function action_index() {

        $this->template->bt_voltar = false;
    }

}

// End Error