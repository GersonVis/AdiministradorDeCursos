<?php
   class Main extends Controller{
       function __construct()
       {
        parent::__construct();
        $this->view->renderizar('main/index');
       }
       
       public function Saludo()
       {
           echo "hola estamos saludando";
       }
   }
?>