<?php
    if($IsAjax){
        require_once "../models/ClientModel.php";
    }else{
        require_once "./models/ClientModel.php";
    }

    class ClientController extends ClientModel{
    /*controller to add client  */
    public function FAdd_client_controller(){

    }/* Fin controlador */

    }