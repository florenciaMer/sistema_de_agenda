<?php

include_once('../config.php');


session_start();
if(isset($_SESSION['usuario_sesion'])) {
    unset($_SESSION['usuario_sesion']);
}
if(isset($_SESSION['usuario_email'])) {
    unset($_SESSION['usuario_email']);
}
if(isset($_SESSION['sesion_email'])) {
    unset($_SESSION['sesion_email']);
}

header("Location: ".APP_URL."/view/login");
?>

