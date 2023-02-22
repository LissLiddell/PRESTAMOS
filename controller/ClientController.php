<?php
    if($IsAjax){
        require_once "../models/ClientModel.php";
    }else{
        require_once "./models/ClientModel.php";
    }

    class ClientController extends ClientModel{
    /*controller to add client  */
    public function FAdd_client_controller(){
        $dni=VmainModel::Fclean_string($_POST['client_dni_reg']);
        $name=VmainModel::Fclean_string($_POST['client_name_reg']);
        $lastname=VmainModel::Fclean_string($_POST['client_lastname_reg']);
        $telephone=VmainModel::Fclean_string($_POST['client_telephone_reg']);
        $adress=VmainModel::Fclean_string($_POST['client_adress_reg']);

         /* verify empty fields */

         if($dni=="" || $name=="" || $lastname=="" || $telephone=="" || $adress==""){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"No has llenado todos los campos que son obligatorios",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*verify data integrity */
        if(VmainModel::Fcheck_data("[0-9-]{1,27}",$dni)){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"El DNI no coincide con el formato solicitado",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(VmainModel::Fcheck_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$name)){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"El Nombre no coincide con el formato solicitado",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(VmainModel::Fcheck_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$lastname)){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"El Apellido no coincide con el formato solicitado",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(VmainModel::Fcheck_data("[0-9()+]{8,20}",$telephone)){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"ElTelefono no coincide con el formato solicitado",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(VmainModel::Fcheck_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}",$adress)){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"La direccion no coincide con el formato solicitado",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }


    }/* Fin controlador */

    }