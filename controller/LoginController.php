<?php
    if($IsAjax){
        require_once "../models/LoginModel.php";
    }else{
        require_once "./models/LoginModel.php";
    }

    class LoginController extends LoginModel{
        /*------ login controller */
        public function start_session_controller(){
            $user=VmainModel::Fclean_string($_POST['usuario_log']);
            $key=VmainModel::Fclean_string($_POST['clave_log']);

             /* verify empty fields */
             if($user=="" || $key==""){
                echo '
                <script> 
                    Swal.fire({
                        title: "Ocurrio un inesperado",
                        text: "No has llenado todos los campos requeridos",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
             }

             /*verify data integrity */
             if(VmainModel::Fcheck_data("[a-zA-Z0-9]{1,35}",$user)){
                echo '
                <script> 
                    Swal.fire({
                        title: "Ocurrio un inesperado",
                        text: "El Nombre de Usuario no coincide con el formato permitido",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
             }

             if(VmainModel::Fcheck_data("[a-zA-Z0-9$@.-]{7,100}",$key)){
                echo '
                <script> 
                    Swal.fire({
                        title: "Ocurrio un inesperado",
                        text: "La contraseña capturada no coincide con el formato permitido",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
             }

             $key = VmainModel::encryption($key);

             $data_login = [
                "Usuario"=>$user,
                "Clave"=>$key
             ];
        }
    }