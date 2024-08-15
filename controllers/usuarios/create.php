<?php 
include_once('../config.php');
$email = $_POST['email'];
$password_user = $_POST['password_user'];
$password_repeat = $_POST['password_repeat'];
$estado = 1;

if ($password == $password_repeat) {
    // echo "las contra coinciden";
    $password_user = password_hash($password_user, PASSWORD_DEFAULT);
 
 }else{
     session_start();
     $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
     $_SESSION['icono'] = 'error';
     header('Location:'.APP_URL.'/view/usuarios/create.php');
 }
 
 $sentencia= $pdo->prepare("SELECT * FROM  tb_usuarios WHERE email = '$email'");
 $sentencia->execute();
 $cuenta = $sentencia->rowCount();
 
 
 
 if ($cuenta>0) {
     session_start();
     $_SESSION['mensaje'] = 'El usuario ya existe en la base de datos';
     $_SESSION['icono'] = 'error';
     ?>
     <script>
         window.history.back();
     </script>
 <?php 
 
 }else{
 
     $sentencia2= $pdo->prepare("INSERT INTO `tb_usuarios`( `email`,`password_user`,`estado`, `fyh_creacion`) 
     VALUES ('$email', '$password_user', '$estado','$fechaHora')");
     $sentencia2->execute();
 
     $sentencia2->bindParam('email', $email);
     $sentencia2->bindParam('password_user', $password_user);
     $sentencia2->bindParam('estado', $estado);
     $sentencia2->bindParam('fyh_creacion', $fyh_creacion);
     
     
     session_start();
     $_SESSION['mensaje'] = 'El usuario se registro de la manera correcta';
     $_SESSION['icono'] = 'success';
     header('Location:'.APP_URL.'/index.php');
 }
 