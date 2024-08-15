<?php

include '../config.php';

$title_anterior = $_GET['title_anterior'];
$title_nuevo = $_GET['title_nuevo'];
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];
$fyh_actualizacion = $fechaHora;

$horaInicial=$hora;

$minutoAnadir=39;
 
$segundos_horaInicial=strtotime($horaInicial)+2400;
 
$horaFinal=date('H:i:s', $segundos_horaInicial);

$end_time=date('H:i:s',strtotime($horaFinal));
$end_time=$horaFinal;
echo $horaFinal;

$sql_check = "SELECT * 
FROM tb_reservas 
WHERE fecha_cita = :fecha
  AND (
    hora_cita = :hora
    OR (
      :hora BETWEEN hora_cita AND DATE_ADD(hora_cita, INTERVAL 39 MINUTE)
    )
  )
  AND estado = '1'";

$sentencia1 = $pdo->prepare($sql_check);
$sentencia1->bindParam(':fecha', $fecha);
$sentencia1->bindParam(':hora', $hora);
$sentencia1->bindParam(':end_time', $end_time);
$sentencia1->execute();

$cuenta = $sentencia1->rowCount();
echo "cuenta";
echo $cuenta;

if ($cuenta > 0) {
    session_start();
    $_SESSION['mensaje'] = 'Ya existe una cita para ese día en ese horario o se encuentra en cita para ese horario';
    $_SESSION['icono'] = 'error';
    ?>
<script> location.href = "<?php echo APP_URL; ?>/index.php"</script>
<?php 
 }else{ 


    $sentencia = $pdo->prepare("UPDATE tb_reservas SET 
    fecha_cita = :fecha,
    hora_cita = :hora,
    title = :title_nuevo,
    start = :fecha,
    end = :fecha,
    fyh_actualizacion = :fyh_actualizacion
    
    WHERE title= :title_anterior");

// Bind the parameters
$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':hora', $hora);
$sentencia->bindParam(':title_anterior', $title_anterior);
$sentencia->bindParam(':title_nuevo', $title_nuevo);
$sentencia->bindParam(':fyh_actualizacion', $fyh_actualizacion);

// Execute the statement
if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = 'Cita modificada con éxito';
    $_SESSION['icono'] = 'success';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/index.php"</script>
    <?php 
}else{
    session_start();
    $_SESSION['mensaje'] = 'La cita no pudo ser modificada';
    $_SESSION['icono'] = 'error';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/index.php"</script>
    <?php 
}
}