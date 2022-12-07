<?php
    require_once "./models/Vmodel.php";
    /*viewcontroller hereda la clase de vmodel donde se incluye el codigo */

    
    /*controlador para obtener plantilla*/
    class ViewController extends Vmodel{
        public function get_template_controller(){
            return require_once "./view/template.php";
        }
        
        /*controlador para obtener vistas*/
        public function get_view_controller(){
            if(isset($_GET['views'])){
                $rute = explode("/",$_GET['views']);
                $request = Vmodel::get_view_model($rute[0]);
            }else{
                $request = "login";
            }
            return $request;
        }
    }