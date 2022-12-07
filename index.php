<?php
    require_once "./config/APP.php";
    require_once "./controller/Vcontroller.php";

    $template = new ViewController();
    $template->get_template_controller();