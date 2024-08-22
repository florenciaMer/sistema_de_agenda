<?php 
include_once('../config.php');
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$email = $_POST['email'];
//$id_paciente = $_POST['id_paciente'];
$fyh_creacion = $fechaHora;
$estado = 1;


 
$sentencia = $pdo->prepare("SELECT * FROM tb_pacientes WHERE 
email =:email OR nombre =:nombre AND apellido =:apellido");

$sentencia->bindParam('nombre', $nombre);
$sentencia->bindParam('apellido', $apellido);
$sentencia->bindParam('email', $email);

 $sentencia->execute();
 $cuenta = $sentencia->rowCount();
 
 
 if ($cuenta>0) {
     session_start();
     $_SESSION['mensaje'] = 'Ya existe un usuario con ese nombre y apellido o email en la base de datos';
     $_SESSION['icono'] = 'error';
     ?>
     <script>
         window.history.back();
     </script>
     
 <?php 
 
 }else{
 
     $sentencia2= $pdo->prepare("INSERT INTO `tb_pacientes`( `nombre`,`apellido`,`direccion`,`telefono`,`celular`,`email`, `fyh_creacion`,`estado`) 
     VALUES ('$nombre', '$apellido','$direccion', '$telefono', '$celular','$email','$fechaHora', '$estado')");
     $sentencia2->execute();
 
     $sentencia2->bindParam('nombre', $nombre);
     $sentencia2->bindParam('apellido', $apellido);
     $sentencia2->bindParam('direccion', $direccion);
     $sentencia2->bindParam('telefono', $telefono);
     $sentencia2->bindParam('celular', $celular);
     $sentencia2->bindParam('email', $email);
     $sentencia2->bindParam('fyh_creacion', $fyh_creacion);
     $sentencia2->bindParam('estado', $estado);
     
     
     session_start();
     $_SESSION['mensaje'] = 'El paciente se registro de la manera correcta';
     $_SESSION['icono'] = 'success';
     header('Location:'.APP_URL.'/view/pacientes/index.php');
 //}
 }