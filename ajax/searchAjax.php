<?php 
    session_start(['name'=>'SPM']);
    require_once "../config/APP.php";

    if(isset($_POST['initial_search']) || isset($_POST['delete_search']) || isset($_POST['start_date']) || isset($_POST['end_date'])){
        $data_url=[
            "usuario"=>"user-search",
            "cliente"=>"client-search",
            "item"=>"item-search",
            "prestamo"=>"reservation-search"
        ];

        if(isset($_POST['model'])){
            $model = $_POST['model'];
            if(!isset($data_url[$model])){
                $alert=[
                    "Alert"=>"simple",
                    "title"=>"Ocurrio un error inesperado",
                    "text"=>"No podemos continuar con la busqueda debido a un error de configuracion",
                    "type"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }
        }else{
            $alert=[
                "Alert"=>"simple",
                "title"=>"Ocurrio un error inesperado",
                "text"=>"No podemos continuar con la busqueda debido a un error de configuracion",
                "type"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($model=="prestamo"){
            $start_date="start_date_".$model;
            $end_date="end_date_".$model;

            // start search 
            if(isset($_POST['start_date'])){

            }
        }else{

        }
    }else{
        session_unset(); 
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }
?>