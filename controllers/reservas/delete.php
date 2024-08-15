<?php

include '../config.php';

// Retrieve GET parameters
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];

// Set the values to be updated
$estado = 0;

// Assuming $fechaHora is defined somewhere or needs to be created based on the current timestamp
$fyh_actualizacion = date('Y-m-d H:i:s'); // Current timestamp

// Prepare the SQL statement
$sentencia = $pdo->prepare("UPDATE tb_reservas SET
    estado = :estado,
    fyh_actualizacion = :fyh_actualizacion
    WHERE fecha_cita = :fecha AND hora_cita = :hora");

// Bind the parameters
$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':fyh_actualizacion', $fyh_actualizacion);
$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':hora', $hora);

// Execute the statement
if ($sentencia->execute()) {
    session_start();
    $_SESSION['mensaje'] = 'Se eliminó la cita correctamente';
    $_SESSION['icono'] = 'success';

    // Redirect after success
    echo '<script> location.href = "' . APP_URL . '";</script>';
} else {
    echo 'No se eliminó de la manera correcta';
    echo '<script> location.href = "' . APP_URL . '";</script>';
}

?>
