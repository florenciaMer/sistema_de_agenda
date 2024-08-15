<?php

include '../config.php';

$id_usuario = $_GET['id_usuario'];
$estado = 0;
//$sentencia= $pdo->prepare("DELETE FROM tb_usuarios WHERE id_usuario=:id_usuario");


$sentencia= $pdo->prepare("UPDATE tb_usuarios SET
 estado=:estado,
 fyh_actualizacion=:fyh_actualizacion
 WHERE id_usuario=:id_usuario");

 $sentencia->bindParam('estado', $estado);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);
$sentencia->bindParam('id_usuario', $id_usuario);
 
if($sentencia->execute()){

    session_start();
    $_SESSION['mensaje'] = 'Se elimino de la manera correcta';
    $_SESSION['icono'] = 'success';
    

?>
<script> location.href = "<?php echo APP_URL; ?>/view/usuarios/index.php"</script>
<?php }else{

echo "No Se elimino de la manera correcta";
?>
<script> location.href = "<?php echo APP_URL; ?>/view/usuarios/index.php"</script>
<?php }
 
?>