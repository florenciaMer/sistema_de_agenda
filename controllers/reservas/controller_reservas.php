<?php 
include_once('../config.php');

$id_paciente = $_POST['id_paciente'];
$fecha_cita = $_POST['fecha_cita'];

$hora_cita = date('H-i-s');
$hora_cita = $_POST['hora_cita'];


$start = $fecha_cita . ' ' . $hora_cita;

$end_time = $hora_cita ;

$horaInicial=$hora_cita;

$minutoAnadir=40;
 
$segundos_horaInicial=strtotime($horaInicial)+2400;
 
$horaFinal=date('H:i:s', $segundos_horaInicial);

$end_time=date('H:i:s',strtotime($horaFinal));


$end = $fecha_cita . ' ' . $end_time;
$fyh_creacion = $fechaHora;
$estado = 1;

// Fetch patient details
$sql = "SELECT nombre, apellido FROM tb_pacientes WHERE id_paciente = :id_paciente";
$query = $pdo->prepare($sql);
$query->bindParam(':id_paciente', $id_paciente);
$query->execute();
$paciente = $query->fetch(PDO::FETCH_ASSOC);

if ($paciente) {
    $nombre = $paciente['nombre'];
    $apellido = $paciente['apellido'];
    $title = $hora_cita . '-' . $nombre . '-' . $apellido . '-'.$fecha_cita ;
} else {
    session_start();
    $_SESSION['mensaje'] = 'Paciente no encontrado';
    $_SESSION['icono'] = 'error';
    header('Location:' . APP_URL . '/index.php');
    exit();
}

$sql_check = "SELECT * FROM tb_reservas 
              WHERE id_paciente = :id_paciente AND fecha_cita = :fecha_cita and estado = '1'
              OR fecha_cita = :fecha_cita AND hora_cita BETWEEN :hora_cita AND :end_time 
              and estado='1'";

$sentencia = $pdo->prepare($sql_check);
$sentencia->bindParam(':id_paciente', $id_paciente);
$sentencia->bindParam(':fecha_cita', $fecha_cita);
$sentencia->bindParam(':hora_cita', $hora_cita);
$sentencia->bindParam(':end_time', $end_time);
$sentencia->execute();

$cuenta = $sentencia->rowCount();


if ($cuenta > 0) {
    session_start();
    $_SESSION['mensaje'] = 'Ya existe una cita para ese día';
    $_SESSION['icono'] = 'error';
    ?>
    <script>
        window.history.back();
    </script>
    <?php
} else {
    // Insert new reservation
    $sql_insert = "INSERT INTO tb_reservas (id_paciente, fecha_cita, hora_cita, title, start, end, fyh_creacion, estado) 
                   VALUES (:id_paciente, :fecha_cita, :hora_cita, :title, :start, :end, :fyh_creacion, :estado)";
    $sentencia2 = $pdo->prepare($sql_insert);
    $sentencia2->bindParam(':id_paciente', $id_paciente);
    $sentencia2->bindParam(':fecha_cita', $fecha_cita);
    $sentencia2->bindParam(':hora_cita', $hora_cita);
    $sentencia2->bindParam(':title', $title);
    $sentencia2->bindParam(':start', $start);
    $sentencia2->bindParam(':end', $end);
    $sentencia2->bindParam(':fyh_creacion', $fyh_creacion);
    $sentencia2->bindParam(':estado', $estado);

    if ($sentencia2->execute()) {
        session_start();
        $_SESSION['mensaje'] = 'La cita se registró de la manera correcta';
        $_SESSION['icono'] = 'success';
        header('Location:' . APP_URL . '/index.php');
    } else {
        session_start();
        $_SESSION['mensaje'] = 'Error al registrar la cita';
        $_SESSION['icono'] = 'error';
        ?>
        <script>
            window.history.back();
        </script>
        <?php
    }
}
?>
