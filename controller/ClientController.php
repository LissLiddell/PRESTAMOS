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

        /* verify DNI*/
        $check_dni=VmainModel::exec_simple_query("SELECT cliente_dni FROM cliente WHERE cliente_dni='$dni'");

        if($check_dni->rowCount()>0){
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"El DNI ingresado ya se encuentra registrado en el sistema",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data_client_reg=[
            "DNI"=>$dni,
            "Nombre"=>$name,
            "Apellido"=>$lastname,
            "telefono"=>$telephone,
            "direccion"=>$adress
        ];

        $add_cliente=ClientModel::Add_client_model($data_client_reg);

        if($add_cliente->rowCount()==1){
            $alert=[
                "Alert"=>"clean",
                "title"=>"Cliente Registrado",
                "text"=>"Los datos del cliente se registraron correctamente",
                "type"=>"success"
            ];
        }else{
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"No hemos podido registrar el cliente, Porfavor intenta de nuevo",
                "type"=>"error"
            ];
        }
        echo json_encode($alert);
    }/* Fin controlador */

    }