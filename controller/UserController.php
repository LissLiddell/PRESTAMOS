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

            if(isset($search) && $search!=""){
                $query= "SELECT SQL_CALC_FOUNDS_ROWS * FROM usuario WHERE ((usuario_id!='$id' AND usuario_id!='1') AND (usuario_dni LIKE '%$search%'
                OR usuario_nombre LIKE '%$search%' OR usuario_apellido LIKE '%$search%' OR usuario_telefono LIKE '%$search%'
                OR usuario_email LIKE '%$search%' OR usuario_usuario LIKE '%$search%'))
                ORDER BY usuario_nombre ASC LIMIT $start,$records";
            }else{
                $query= "SELECT SQL_CALC_FOUNDS_ROWS * FROM usuario WHERE usuario_id!='$id' AND usuario_id!='1'
                ORDER BY usuario_nombre ASC LIMIT $start,$records";
            }

            $conn = VmainModel::Conn();
            $data = $conn->query($query);
            $data = $data->fetchAll();

            $total = $conn->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npage = ceil($total/$records);

            $table.= '    <div class="table-responsive">
                                <table class="table table-dark table-sm">
                                    <thead>
                                        <tr class="text-center roboto-medium">
                                            <th>#</th>
                                            <th>DNI</th>
                                            <th>NOMBRE</th>
                                            <th>TELÉFONO</th>
                                            <th>USUARIO</th>
                                            <th>EMAIL</th>
                                            <th>ACTUALIZAR</th>
                                            <th>ELIMINAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            if ($total>=1 && $page<=$Npage) {
                $count=$start+1;
                $reg_start=$start+1;
                foreach ($data as $rows) {
                    $table.='
                    <tr class="text-center" >
                        <td>'.$count.'</td>
                        <td>'.$rows['usuario_dni'].'</td>
                        <td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>
                        <td>'.$rows['usuario_telefono'].'</td>
                        <td>'.$rows['usuario_usuario'].'</td>
                        <td>'.$rows['usuario_email'].'</td>
                        <td>
                            <a href="'.SERVERURL.'user-update/'.VmainModel::encryption($rows['usuario_id']).'/" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>	
                            </a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="'.SERVERURL.'ajax/userAjax.php" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="user_id_del" value="'.VmainModel::encryption($rows['usuario_id']).'">
                                <button type="submit" class="btn btn-warning">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>';
                    $count++;
                }
                $reg_end=$count-1;
            } else {
                if ($total>=1) {
                    $table.='<tr class="text-center" ><td colspan="9">
                    <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Dar click aqui para recargar el listado</a>
                    </td></tr>';
                } else {
                    $table.='<tr class="text-center" ><td colspan="9">No hay registros en el sistema</td></tr>';
                }
            }

            $table.='</tbody></table></div>';
            
            if ($total>=1 && $page<=$Npage) {
                $table.='<p class="text-right">Mostrando usuario '.$reg_start.' al '.$reg_end.' de un total de '.$total.'</p>';

                $table.=VmainModel::F_pagination_tables($page,$Npage,$url,7);
            } 
            return $table;
            
        }/* end of controller*/ 

        /*controller delete user*/
        public function Fdelete_user_controller(){

                /*Request ID user*/
                $id=VmainModel::decryption($_POST['user_id_del']);
                $id=VmainModel::Fclean_string($id);

                /*check main user*/
                if($id==1){
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"No se puede eliminar el usuario principal del sistema",
                        "type"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                 /*check user in BD*/
                $user_check=VmainModel::exec_simple_query("SELECT usuario_id FROM usuario WHERE usuario_id='$id'");

                if($user_check->rowCount()<=0){
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"El usuario que intenta eliminar no existe en el sistema",
                        "type"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();     
                }

                 /*check the loans*/
                 $loan_check=VmainModel::exec_simple_query("SELECT usuario_id FROM prestamo WHERE usuario_id='$id' LIMIT 1");

                 if($loan_check->rowCount()>0){
                     $alert=[
                         "Alert"=>"simple",
                         "title"=>"Ocurrio un error inesperado",
                         "text"=>"No podemos eliminar este usuario debido a que tiene prestamos asociados, recomendamos 
                         deshabilitar el usuario si ya no utilizado",
                         "type"=>"error"
                     ];
                     echo json_encode($alert);
                     exit();     
                 }

                 /*check privilegue*/
                 session_start(['name'=>'SPM']);

                 if($_SESSION['privilegio_spm']!= 1){
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"No tienes los permisos necesarios para realizar esta operación",
                        "type"=>"error"
                    ];
                    echo json_encode($alert);
                    exit(); 
                 }

                 $delete_user=UserModel::delete_user_model($id);
                 if($delete_user->rowCount()==1){
                    $alert=[
                        "Alert"=>"recargar",
                        "title"=>"Usuario eliminado",
                        "text"=>"El usuario ha sido eliminado del sistema exitosamente",
                        "type"=>"success"
                    ];
                 }else{
                    $alert=[
                        "Alert"=>"simple",
                        "title"=>"Ocurrio un error inesperado",
                        "text"=>"No hemos podido eliminar el usuario, por favor intente nuevamente",
                        "type"=>"error"
                    ];
                 }
                 echo json_encode($alert);
        }/* end of controller*/ 

        /*controller data user*/
        public function data_user_controller($type,$id){
            $type=VmainModel::Fclean_string($type);

            $id=VmainModel::decryption($id);
            $id=VmainModel::Fclean_string($id);

            return UserModel::data_user_model($type,$id);
        
        }/* end of controller*/ 

        /*controller update user */
        public function update_user_controller($data){

        }/* end of controller*/
    }