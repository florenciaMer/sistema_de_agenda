<?php

include '../config.php';

$id_valor = $_GET['id_valor'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$id_paciente = $_GET['id_paciente'];
$estado = 0;
//$sentencia= $pdo->prepare("DELETE FROM tb_usuarios WHERE id_usuario=:id_usuario");

$sql_check = "SELECT * FROM tb_reservas 
              WHERE  id_paciente = :id_paciente AND fecha_cita BETWEEN :desde AND :hasta 
              and pagado='1'";

$sentencia = $pdo->prepare($sql_check);
$sentencia->bindParam(':id_paciente', $id_paciente);
$sentencia->bindParam(':desde', $desde);
$sentencia->bindParam(':hasta', $hasta);
$sentencia->execute();

$cuenta = $sentencia->rowCount();


if ($cuenta > 0) {
    session_start();
    $_SESSION['mensaje'] = 'No se puede eliminar el valor debido a que ya se facturó un periodo con el mismo';
    $_SESSION['icono'] = 'error';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/view/valores/index.php"</script>
<?php 
}else{

echo $desde;
echo 'hasta';
echo $hasta;
echo $id_paciente;
$sentencia= $pdo->prepare("UPDATE tb_valores 
    SET estado = :estado, 
        fyh_actualizacion = :fyh_actualizacion
    WHERE id_paciente_valor = :id_paciente 
      AND desde >= :desde 
      AND hasta <= :hasta 
 ");

$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':fyh_actualizacion', $fechaHora);
$sentencia->bindParam(':id_paciente', $id_paciente);
$sentencia->bindParam(':desde', $desde);
$sentencia->bindParam(':hasta', $hasta);
 
if($sentencia->execute()){

    session_start();
    $_SESSION['mensaje'] = 'Se elimino de la manera correcta';
    $_SESSION['icono'] = 'success';
    

?>
<script> location.href = "<?php echo APP_URL; ?>/view/valores/index.php"</script>
<?php }else{

echo "No Se elimino de la manera correcta";
?>
<script> location.href = "<?php echo APP_URL; ?>/view/valores/index.php"</script>
<?php }
}
?>