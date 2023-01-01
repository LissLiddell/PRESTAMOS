<?php
    $IsAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['token']) && isset($_POST['usuario'])){
        /*include instance for contoller  */
        require_once "../controller/LoginController.php";
        $ins_login = new LoginController();

        echo $ins_login->Log_out_controller();
    }else{
        session_start(['name'=>'SPM']);
        session_unset(); 
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }