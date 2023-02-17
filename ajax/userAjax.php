<?php
    $IsAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['usuario_dni_reg']) || isset($_POST['user_id_for']) || isset($_POST['user_id_up'])){
        /*include instance for contoller  */
        require_once "../controller/UserController.php";
        $ins_user = new UserController();

        /*add an user */
        if(isset($_POST['usuario_dni_reg']) && $_POST['usuario_nombre_reg']){
            echo $ins_user->Fadd_user_controller();
        }

        /*delete an user */
        if(isset($_POST['user_id_del'])){
            echo $ins_user->Fdelete_user_controller();
        }

        /*update an user */
        if(isset($_POST['user_id_up'])){
            echo $ins_user->update_user_controller($data_user_up);
        }

    }else{
        session_start(['name'=>'SPM']);
        session_unset(); 
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }