<?php
class Main extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function Renderizar($nombreVista){
       
        require_once "views/$nombreVista.php";
    }
}
?>