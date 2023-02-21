<?php
    require_once "VmainModel.php";

    class ClientModel extends VmainModel{
        protected static function Add_client_model($data){
            $sql=VmainModel::Conn()->prepare("INSERT INTO cliente(cliente_dni,cliente_nombre,cliente_apellido,cliente_telefono,cliente_direccion) VALUES(:DNI,:Nombre,:Apellido,:telefono,:direccion)");

            $sql->bindParam(":DNI",$data['DNI']);
            $sql->bindParam(":Nombre",$data['Nombre']);
            $sql->bindParam(":Apellido",$data['Apellido']);
            $sql->bindParam(":telefono",$data['telefono']);
            $sql->bindParam(":direccion",$data['direccion']);

            $sql->execute();
            return $sql;
        }
    }