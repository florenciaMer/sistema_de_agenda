<?php 
include_once('../config.php');
$id_paciente = $_POST['id_paciente'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$precio = $_POST['precio'];
$estado = 1;

$cuenta=0;
 $sentencia= $pdo->prepare("SELECT * FROM `tb_valores` WHERE id_paciente_valor = '$id_paciente' AND desde >= '$desde'AND hasta <='$hasta' ");
 $sentencia->execute();
 $cuenta = $sentencia->rowCount();
 
 echo $cuenta;
 
 if ($cuenta>0) {
     session_start();
     $_SESSION['mensaje'] = 'El paciente ya tiene valores asignados para ese período, debe editar la información';
     $_SESSION['icono'] = 'error';
     ?>
     <script>
         window.history.back();
     </script>
 <?php 
 
 }else{
 
 
     $sentencia2= $pdo->prepare("INSERT INTO `tb_valores`( `id_paciente_valor`,`desde`,`hasta`,`precio`,`estado`, `fyh_creacion`) 
     VALUES ('$id_paciente', '$desde', '$hasta','$precio','$estado','$fechaHora')");
     $sentencia2->execute();
 
     $sentencia2->bindParam('email', $email);
     $sentencia2->bindParam('password_user', $password_user);
     $sentencia2->bindParam('estado', $estado);
     $sentencia2->bindParam('fyh_creacion', $fyh_creacion);
     
     
     session_start();
     $_SESSION['mensaje'] = 'El Valor se registro de la manera correcta';
     $_SESSION['icono'] = 'success';
     header('Location:'.APP_URL.'/view/valores/index.php');
 }
 