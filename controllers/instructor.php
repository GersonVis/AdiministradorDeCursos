<?php

class Instructor extends Controller{
    function __construct()
    {
        parent::__construct();
    }
    function prueba(){
        $url=$_POST['url'];
        $this->view->url=$url;
        $this->view->renderizar("instructor/index");
    }
}
?>