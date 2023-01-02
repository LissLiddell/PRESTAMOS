<?php
    if($IsAjax){
        require_once "../models/UserModel.php";
    }else{
        require_once "./models/UserModel.php";
    }

    class UserController extends UserModel{
        /*controller to add user  */
        public function Fadd_user_controller(){
            $dni = VmainModel::Fclean_string($_POST['usuario_dni_reg']);
            $name = VmainModel::Fclean_string($_POST['usuario_nombre_reg']);
            $lastName = VmainModel::Fclean_string($_POST['usuario_apellido_reg']);
            $telephone = VmainModel::Fclean_string($_POST['usuario_telefono_reg']);
            $adress = VmainModel::Fclean_string($_POST['usuario_direccion_reg']);

            $user = VmainModel::Fclean_string($_POST['usuario_usuario_reg']);
            $Email = VmainModel::Fclean_string($_POST['usuario_email_reg']);
            $key1 = VmainModel::Fclean_string($_POST['usuario_clave_1_reg']);
            $key2 = VmainModel::Fclean_string($_POST['usuario_clave_2_reg']);

            $privilege = VmainModel::Fclean_string($_POST['usuario_privilegio_reg']);

            /* verify empty fields */

            if($dni=="" || $name=="" || $lastName=="" || $user=="" || $key1=="" || $key2==""){
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
            if(VmainModel::Fcheck_data("[0-9-]{10,20}",$dni)){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El DNI no coincide con el formato solicitado",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            if(VmainModel::Fcheck_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",$name)){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El Nombre no coincide con el formato solicitado",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            if(VmainModel::Fcheck_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,35}",$lastName)){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El Apellido no coincide con el formato solicitado",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            if($telephone!=""){
                if(VmainModel::Fcheck_data("[0-9()+]{8,20}",$telephone)){
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"El Telefono no coincide con el formato solicitado",
                        "type"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
            }

            
            if($adress!=""){
                if(VmainModel::Fcheck_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$adress)){
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"La DIRECCION no coincide con el formato solicitado",
                        "type"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
            }

            if(VmainModel::Fcheck_data("[a-zA-Z0-9]{1,35}",$user)){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El nombre de Usuario no coincide con el formato solicitado",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            if(VmainModel::Fcheck_data("[a-zA-Z0-9$@.-]{7,100}",$key1) || VmainModel::Fcheck_data("[a-zA-Z0-9$@.-]{7,100}",$key2)){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"Las contraseñas no coinciden con el formato solicitado",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            /*check not repeat DNI */
            $check_dni=VmainModel::exec_simple_query("SELECT usuario_dni FROM usuario WHERE usuario_dni = '$dni'");
            if($check_dni->rowCount()>0){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El DNI ingresado ya existe",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            /*check not repeat user */
            $check_user=VmainModel::exec_simple_query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$user'");
            if($check_user->rowCount()>0){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El Usuario ingresado ya existe",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            /*check not repeat email */
            if($Email!=""){
                if(filter_var($Email,FILTER_VALIDATE_EMAIL)){
                    $check_mail=VmainModel::exec_simple_query("SELECT usuario_email FROM usuario WHERE usuario_email = '$Email'");
                        if($check_mail->rowCount()>0){
                            $alert=[
                                "Alert"=>"simple",
                                "title"=>"Ocurrio un error inesperado",
                                "text"=>"El Correo ingresado ya esta dado de alta en el sistema",
                                "type"=>"error"
                            ];
                            echo json_encode($alert);
                            exit();
                        }
                }else{
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"El correo ingresado no es valido",
                        "type"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
            }


            /* check password */
            if($key1!=$key2){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"Las contraseñas capturadas no coinciden",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }else{
                $key=VmainModel::encryption($key1);
            }

             /* check privilege */
            if($privilege<1 || $privilege>3){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"El privilegio seleccionado no es valido",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }

            $data_user_reg=[
                "DNI"=>$dni,
                "Nombre"=>$name,
                "Apellido"=>$lastName,
                "Telefono"=>$telephone,
                "Direccion"=>$adress,
                "Email"=>$Email,
                "Usuario"=>$user,
                "Clave"=>$key,
                "Estado"=>"Activa",
                "Privilegio"=>$privilege
            ];

            $add_user=UserModel::Fadd_user_model($data_user_reg);

            if($add_user->rowCount()==1){
                $alert=[
                    "Alert"=>"clean",
                    "title"=>"Usuario Registrado",
                    "text"=>"Los datos del usuario han sido registrados con exito",
                    "type"=>"success"
                ];
            }else{
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"No hemos podido registrar el usuario",
                    "type"=>"error"
                ];
            }
            echo json_encode($alert);
        } /* end of controller*/ 

        /*controller user page*/
        public function page_user_controller($page,$records,$privilege,$id,$url,$search){
            $page = VmainModel::Fclean_string($page);
            $records = VmainModel::Fclean_string($records);
            $privilege = VmainModel::Fclean_string($privilege);
            $id = VmainModel::Fclean_string($id);

            $url = VmainModel::Fclean_string($url);
            $url=SERVERURL.$url."/";

            $search = VmainModel::Fclean_string($search);
            $table = "";

            $page = (isset($page) && $page>0) ? (int) $page: 1;
            $start = ($page>0) ? (($page*$records)-$records): 0;
        }/* end of controller*/ 
    }