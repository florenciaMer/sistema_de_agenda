<?php
include_once('../config.php');


$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM tb_usuarios WHERE email = '$email' and estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

$contador = 0;
foreach ($usuarios as $usuario) {
   $contador++;
   $email = $usuario['email'];
   $password_tabla = $usuario['password_user'];
}

if ($contador>0 && (password_verify($password, $password_tabla))) {

    session_start();
    $_SESSION['mensaje'] = "Bievenido al sistema";
    $_SESSION['icono'] = "success";
    $_SESSION['sesion_email'] = $email;
    header("Location:".APP_URL.'/index.php');

}else{
    session_start();
    $_SESSION['mensaje'] = "Datos incorrectos, vuelva a intentarlo muchas gracias";
    $_SESSION['icono'] = "error";
    header('Location:'.APP_URL."/view/login/index.php");
}