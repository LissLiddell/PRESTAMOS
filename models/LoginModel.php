<?php
    require_once "VmainModel.php";

    class LoginModel extends VmainModel{
        /*------ Model for start session ------- */
        protected static function start_session_model($data){
            $sql=VmainModel::Conn()->prepare("SELECT * FROM usuario 
            WHERE usuario_usuario=:Usuario AND usuario_clave=:Clave AND usuario_estado='Activa'");
            $sql->bindParam(":Usuario",$data['Usuario']);
            $sql->bindParam(":Clave",$data['Clave']);
            $sql->execute();
            return $sql;
        }
    }