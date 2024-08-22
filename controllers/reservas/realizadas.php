<?php
include_once('../config.php');
$fecha_cita = $_GET['fecha_cita'];
$hora_cita= $_GET['hora_cita'];
$nombre= $_GET['nombre'];
$apellido= $_GET['apellido'];
$fyh_actualizacion = $fechaHora;
$sql = "SELECT * FROM tb_pacientes WHERE nombre = '$nombre' AND apellido = '$apellido'
 AND estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$paciente_datos = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($paciente_datos as $paciente) {
    $id_paciente = $paciente['id_paciente'];
    $nombre = $paciente['nombre'];
    $apellido = $paciente['apellido'];
    $direccion = $paciente['direccion'];
    $telefono = $paciente['telefono'];
    $celular = $paciente['celular'];
    $email = $paciente['email'];
    $fecha_creacion = $paciente['fyh_creacion'];
}

// modificar el campo realizada en reservas
$sentencia = $pdo->prepare("UPDATE tb_reservas SET 
realizada = '1',
fyh_actualizacion = :fyh_actualizacion

WHERE id_paciente= :id_paciente AND fecha_cita= :fecha_cita AND hora_cita = :hora_cita");

// Bind the parameters
$sentencia->bindParam(':fecha_cita', $fecha_cita);
$sentencia->bindParam(':hora_cita', $hora_cita);
$sentencia->bindParam(':id_paciente', $id_paciente);
$sentencia->bindParam(':fyh_actualizacion', $fyh_actualizacion);

// Execute the statement
if($sentencia->execute()){
session_start();
$_SESSION['confirmada'] = 1;
$_SESSION['mensaje'] = 'Cita confirmada con éxito';
$_SESSION['icono'] = 'success';
?>
<script> location.href = "<?php echo APP_URL; ?>/index.php?"</script>
<?php 
}else{
session_start();
$_SESSION['confirmada'] = 0;
$_SESSION['mensaje'] = 'La cita no pudo ser modificada';
$_SESSION['icono'] = 'error';
?>
<script> location.href = "<?php echo APP_URL; ?>/index.php"</script>
<?php 
}
