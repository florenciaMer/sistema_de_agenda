<?php 
include_once(dirname(__DIR__)."/config.php");
 $id_paciente = $_POST['id_paciente'];
 $desde = $_POST['desde'];
 $hasta = $_POST['hasta'];

$pagado = 1;

$cuenta=0;



 $sentencia= $pdo->prepare("SELECT * FROM tb_reservas
  WHERE id_paciente = :id_paciente
 AND fecha_cita >= :desde
 AND fecha_cita <= :hasta
 AND pagado = '0'
 AND estado = '1'
 ");

$sentencia->bindParam(':desde', $desde);
$sentencia->bindParam(':hasta', $hasta);
$sentencia->bindParam(':id_paciente', $id_paciente);

 $sentencia->execute();
 $cuenta = $sentencia->rowCount();

 if ($cuenta>0) {

     session_start();
  $_SESSION['citas_a_facturar_datos'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

foreach ($_SESSION['citas_a_facturar_datos'] as $citas_a_facturar) {
    $_SESSION['id_paciente'] = $citas_a_facturar['id_paciente'];
    $_SESSION['fecha_cita'] = $citas_a_facturar['fecha_cita'];
    $_SESSION['hora_cita'] = $citas_a_facturar['hora_cita'];
    $_SESSION['estado'] = $citas_a_facturar['estado'];
    $_SESSION['pagado'] = $citas_a_facturar['pagado'];
   // $_SESSION['realizada'] = $citas_a_facturar['realizada'];
    $_SESSION['title'] = $citas_a_facturar['title'];
    $_SESSION['fyh_creacion'] = $citas_a_facturar['fyh_creacion'];
    $_SESSION['desde'] = $desde;
    $_SESSION['hasta'] = $hasta;
}
     header('Location:'.APP_URL.'/view/facturacion/datos_facturacion_paciente.php');
 
 }else{
    session_start();
    $_SESSION['mensaje'] = 'No se encontraron datos';
    $_SESSION['icono'] = 'success';
    header('Location:'.APP_URL.'/view/facturacion/datos_facturacion_paciente.php');
 }
 