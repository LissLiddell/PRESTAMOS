<?php
    $IsAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['usuario_dni_reg'])){
        /*include instance for contoller  */
        require_once "../controller/UserController.php";
        $ins_user = new UserController();

        /*add an user */
        if(isset($_POST['usuario_dni_reg']) && $_POST['usuario_nombre_reg']){
            echo $ins_user->Fadd_user_controller();
        }
    }else{
        session_start(['name'=>'SPM']);
        session_unset(); 
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }