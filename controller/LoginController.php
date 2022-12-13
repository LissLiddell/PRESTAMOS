<?php
    if($IsAjax){
        require_once "../models/LoginModel.php";
    }else{
        require_once "./models/LoginModel.php";
    }

    class LoginController extends LoginModel{
        /*------ login controller */
        public function start_session_controller(){

        }
    }