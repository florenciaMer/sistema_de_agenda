<?php

include '../config.php';

$id_valor = $_GET['id_valor'];
$estado = 0;
//$sentencia= $pdo->prepare("DELETE FROM tb_usuarios WHERE id_usuario=:id_usuario");


$sentencia= $pdo->prepare("UPDATE tb_valores SET
 estado=:estado,
 fyh_actualizacion=:fyh_actualizacion
 WHERE id_paciente=:id_paciente");

 $sentencia->bindParam('estado', $estado);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);
$sentencia->bindParam('id_paciente', $id_paciente);
 
if($sentencia->execute()){

    session_start();
    $_SESSION['mensaje'] = 'Se elimino de la manera correcta';
    $_SESSION['icono'] = 'success';
    

?>
<script> location.href = "<?php echo APP_URL; ?>/view/pacientes/index.php"</script>
<?php }else{

echo "No Se elimino de la manera correcta";
?>
<script> location.href = "<?php echo APP_URL; ?>/view/pacientes/index.php"</script>
<?php }
 
?>