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
    }/* End controller */

    /*controller client page*/
    public function page_client_controller($page,$records,$privilege,$url,$search){
        $page = VmainModel::Fclean_string($page);
        $records = VmainModel::Fclean_string($records);
        $privilege = VmainModel::Fclean_string($privilege);

        $url = VmainModel::Fclean_string($url);
        $url=SERVERURL.$url."/";

        $search = VmainModel::Fclean_string($search);
        $table = "";

        $page = (isset($page) && $page>0) ? (int) $page: 1;
        $start = ($page>0) ? (($page*$records)-$records): 0;

        if(isset($search) && $search!=""){
            $query= "SELECT SQL_CALC_FOUNDS_ROWS * FROM cliente WHERE cliente_dni LIKE '%$search%'
            OR cliente_nombre LIKE '%$search%' OR cliente_apellido LIKE '%$search%' OR cliente_telefono LIKE '%$search%'
            ORDER BY cliente_nombre ASC LIMIT $start,$records";
        }else{
            $query= "SELECT SQL_CALC_FOUNDS_ROWS * FROM cliente
            ORDER BY cliente_nombre ASC LIMIT $start,$records";
        }

        $conn = VmainModel::Conn();
        $data = $conn->query($query);
        $data = $data->fetchAll();

        $total = $conn->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();   

        $Npage = ceil($total/$records);

        $table.='    <div class="table-responsive">
                            <table class="table table-dark table-sm">
                                <thead>
                                    <tr class="text-center roboto-medium">
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>TELÉFONO</th>
                                        <th>DIRECCIÓN</th>';
                                        if($privilege==1 || $privilege==2){
                                            $table.='<th>ACTUALIZAR</th>';
                                        }
                                        if($privilege==1){
                                            $table.='<th>ELIMINAR</th>';
                                        }
                                        $table.= '</tr>
                                </thead>
                                <tbody>';
        if ($total>=1 && $page<=$Npage) {
            $count=$start+1;
            $reg_start=$start+1;
            foreach ($data as $rows) {
                $table.='
                <tr class="text-center" >
                    <td>'.$count.'</td>
                    <td>'.$rows['cliente_dni'].'</td>
                    <td>'.$rows['cliente_nombre'].'</td>
                    <td>'.$rows['cliente_apellido'].'</td>
                    <td>'.$rows['cliente_telefono'].'</td>
                    <td><button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'" data-content="'.$rows['cliente_direccion'].'">
                    <i class="fas fa-info-circle"></i>
                </button></td>';
                if($privilege==1 || $privilege==2){
                    $table.='<td>
                        <a href="'.SERVERURL.'client-update/'.VmainModel::encryption($rows['cliente_id']).'/" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i>	
                        </a>
                    </td>';
                }  
                
                if($privilege==1){
                    $table.='<td>
                        <form class="FormularioAjax" action="'.SERVERURL.'ajax/clientAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="client_id_del" value="'.VmainModel::encryption($rows['cliente_id']).'">
                            <button type="submit" class="btn btn-warning">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td> ';
                }                    
                    $table.='</tr>';
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
            $table.='<p class="text-right">Mostrando cliente '.$reg_start.' al '.$reg_end.' de un total de '.$total.'</p>';

            $table.=VmainModel::F_pagination_tables($page,$Npage,$url,7);
        } 
        return $table;
        
    }/* end of controller*/ 
}