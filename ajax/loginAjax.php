<?php
    $IsAjax = true;
    require_once "../config/APP.php";

    if(true){

    }else{
        session_start(['name'=>'SPM']);
        session_unset(); 
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }