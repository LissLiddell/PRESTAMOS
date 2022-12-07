<?php
    class Vmodel{
        
        /*------- modelo para obtener las vistas ----*/
        /*funcion protegida estatica que obtiene el parametro vista del modelo */
        protected static function get_view_model($view){
            /* lista blanca que si se puede poner en la url, que este dentro del sistema*/
            $WhiteList = ["home","client-list","client-new","client-search","client-update",
        "company","home","item-list","item-new","item-search","item-update","reservation-list",
        "reservation-new","reservation-pending","reservation-reservation","reservation-search",
    "reservation-update","user-list","user-new","user-search","user-update"];
            if(in_array($view,$WhiteList)){
                if(is_file("./view/content/".$view."-v.php")){
                    $content = "./view/content/".$view."-v.php";
                }else{
                    $content = "404";
                }
            }elseif($view=="login" || $view=="index"){
                $content = "login";
            }else{
                $content = "404";
            }
            return $content;
        }
    }