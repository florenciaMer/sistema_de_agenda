<?php

include '../config.php';

$id_paciente = $_GET['id_paciente'];
$estado = 0;
//$sentencia= $pdo->prepare("DELETE FROM tb_usuarios WHERE id_usuario=:id_usuario");

$sentencia1= $pdo->prepare("SELECT * FROM  tb_valores WHERE id_paciente_valor = '$id_paciente'");
 $sentencia1->execute();
 $cuenta1 = $sentencia1->rowCount();
 
 if ($cuenta1>0) {

  session_start();
    $_SESSION['mensaje'] = 'No es posible eliminar al paciente debido a que tiene una lista de valores asociada';
    $_SESSION['icono'] = 'error';
    

?>
<script> location.href = "<?php echo APP_URL; ?>/view/pacientes/index.php"</script>
<?php }else{

$sentencia2= $pdo->prepare("SELECT * FROM  tb_reservas WHERE id_paciente = '$id_paciente'");
$sentencia2->execute();
$cuenta2 = $sentencia2->rowCount();

if ($cuenta2>0) {

 session_start();
   $_SESSION['mensaje'] = 'No es posible eliminar al paciente debido a que tiene citas realizadas por liquidar';
   $_SESSION['icono'] = 'error';
   ?>
   <script> location.href = "<?php echo APP_URL; ?>/view/pacientes/index.php"</script>
<?php }else{




    $sentencia= $pdo->prepare("UPDATE tb_pacientes SET
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
}
}
?>