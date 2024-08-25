<?php

include '../config.php';




// Recuperar los parámetros GET
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$hora = isset($_GET['hora']) ? $_GET['hora'] : '';
$title = isset($_GET['title_nuevo']) ? $_GET['title_nuevo'] : '';
$title_anterior = isset($_GET['title_anterior']) ? $_GET['title_anterior'] : '';

// Asegúrate de que todos los valores sean los esperados y están definidos
if ($title_anterior == '') {
    echo json_encode(['status' => 'error', 'message' => 'Title anterior no está definido']);
    exit();
}

// Establecer el valor a actualizar
$estado = 0;

$sql_check = "SELECT * FROM tb_reservas 
              WHERE fecha_cita = :fecha AND hora_cita = :hora  
              and estado='1'";

$sentencia = $pdo->prepare($sql_check);
$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':hora', $hora);
$sentencia->execute();

$cuenta = $sentencia->rowCount();


if ($cuenta > 0) {
    session_start();
    $_SESSION['mensaje'] = 'Ya existe una cita para ese día en ese horario';
    $_SESSION['icono'] = 'error';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/index.php"</script>
   <?php
    exit; 
}else{


    // Obtener la fecha y hora actuales
    $fyh_actualizacion = date('Y-m-d H:i:s'); // Timestamp actual

    // Preparar la consulta SQL
    $sql = "UPDATE tb_reservas 
    SET hora_cita = :hora, 
        title = :title_nuevo,
        fyh_actualizacion = :fyh_actualizacion
    WHERE title = :title_anterior";

$query = $pdo->prepare($sql);

// Vincular los parámetros correctamente
$query->bindParam(':hora', $hora);
$query->bindParam(':title_nuevo', $title);
$query->bindParam(':fyh_actualizacion', $fyh_actualizacion);
$query->bindParam(':title_anterior', $title_anterior);

// Ejecutar la consulta y verificar el resultado
if ($query->execute()) {
    session_start();
    $_SESSION['mensaje'] = 'Se modificó correctamente la cita';
    $_SESSION['icono'] = 'success';
    ?>
    <script> location.href = "<?php echo APP_URL; ?>/index.php"</script>
   <?php
    exit; 
} else {
echo json_encode(['status' => 'error']);
}
}
?>
