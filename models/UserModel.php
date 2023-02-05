<?php
    require_once "VmainModel.php";

    class UserModel extends VmainModel{
        /*model to add user  */
        protected static function Fadd_user_model($data){
            $sql=VmainModel::Conn()->prepare("INSERT INTO usuario(usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio) 
            VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Email,:Usuario,:Clave,:Estado,:Privilegio)");
            $sql->bindParam(":DNI",$data['DNI']);
            $sql->bindParam(":Nombre",$data['Nombre']);
            $sql->bindParam("Apellido",$data['Apellido']);
            $sql->bindParam(":Telefono",$data['Telefono']);
            $sql->bindParam(":Direccion",$data['Direccion']);
            $sql->bindParam(":Email",$data['Email']);
            $sql->bindParam(":Usuario",$data['Usuario']);
            $sql->bindParam(":Clave",$data['Clave']);
            $sql->bindParam(":Estado",$data['Estado']);
            $sql->bindParam(":Privilegio",$data['Privilegio']);
            $sql->execute();

            return $sql;
        }

        /*model to delete user */
        protected static function delete_user_model($id){
            $sql= VmainModel::Conn()->prepare("DELETE FROM usuario WHERE usuario_id=:ID");

            $sql->bindParam(":ID",$id);
            $sql->execute();

            return $sql;
        }

        /*model datas to user */
        protected static function data_user_model($type,$id){
            if($type=="Unico"){
                $sql=VmainModel::Conn()->prepare("SELECT * FROM usuario WHERE usuario_id=:ID");
                $sql->bindParam(":ID",$id);
            }elseif($type=="Conteo"){
                $sql=VmainModel::Conn()->prepare("SELECT usuario_id FROM usuario WHERE usuario_id!='1'");
            }
            $sql->execute();
            return $sql;
        }
    }