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
        $view->relacionados = ORM::factory("blog")->with("blogcategorias")
                                ->and_where_open();
                                foreach($view->blogcategorias as $cat){
                                    $view->relacionados = $view->relacionados->or_where("blogcategorias.CAT_ID", "=", $cat->CAT_ID);
                                }
                                $view->relacionados = $view->relacionados->and_where_close()
                                ->where("blog.BLO_ID", "!=", $id)
                                ->group_by('blog.BLO_ID')
                                ->order_by('blog.BLO_ID', 'DESC')
                                ->limit(3)
                                ->find_all();

        $tituloface = $view->blog->BLO_TITULO;

        $imagem = glob('admin/upload/blog/'.$view->blog->BLO_ID.'.*');
        if ($imagem){
          $img = $imagem[0];
        }else{
            $img = false;
        }

        $this->template->faceHeader = '<meta property="og:title" content="'.strip_tags($tituloface).'" /> <!-- título do artigo -->
        <meta property="og:site_name" content="'.$this->empresa["nome"].'" /> <!-- nome do site (não URL) -->
        <meta property="og:url" content="http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"].'" /> <!-- permalink do artigo -->
        <meta property="og:description" content="'.$this->limitar_palavras(trim(strip_tags($view->blog->BLO_TEXTO)), 20).'" /> <!-- detalhes sobre o conteúdo da página. SUGESTÃO: usar o texto de introdução -->
        <meta property="og:image" content="http://'.$_SERVER['SERVER_NAME'].url::base().$img.'" /> <!-- imagem do produto-->
        <meta property="fb:app_id" content="2222804991343598" /> <!-- id do app no facebook -->
        <meta property="og:type" content="article" /> <!-- tipo do conteúdo -->
        <meta property="og:locale" content="pt_BR" /> <!-- país e idioma -->
        <meta property="article:author" content="https://www.facebook.com/pointofsalebrasil/"/> <!-- link do perfil do autor no facebook -->
        <meta property="article:publisher" content="https://www.facebook.com/pointofsalebrasil/" /> <!-- link do "editor" do conteúdo -->';
        
        $this->template->conteudo = $view;
    }

}

// End quem somos
?>