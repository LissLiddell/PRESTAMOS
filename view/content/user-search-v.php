<!-- Page header -->
<?php if($_SESSION['privilegio_spm']!=1){
    echo $lc->force_log_out_controller();
    exit();
}?>
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO
    </h3>
    <p class="text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL;?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL;?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL;?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
        </li>
    </ul>	
</div>

<!-- Content -->
<?php 
    if(!isset($_SESSION['search_usuario']) && empty($_SESSION['search_usuario'])){
?>
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/searchAjax.php" method="POST" data-form="default" autocomplete="off">
        <input type="hidden" name="model" value="usuario">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué usuario estas buscando?</label>
                        <input type="text" class="form-control" name="initial_search" id="inputSearch" maxlength="30">
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<?php  }else{ ?>
<div class="container-fluid">
    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/searchAjax.php" method="POST" data-form="search" autocomplete="off">
    <input type="hidden" name="model" value="usuario">
        <input type="hidden" name="delete_search" value="delete">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Resultados de la busqueda <strong>“<?php echo $_SESSION['search_usuario'];?>”</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>



<div class="container-fluid">
    <?php 
    require_once "./controller/UserController.php";
    $ins_user = new UserController();

    echo $ins_user->page_user_controller($page[1],15,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$page[0],$_SESSION['search_usuario']);
    ?>
</div>
<?php } ?>