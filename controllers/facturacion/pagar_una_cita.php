<?php
include_once('../../controllers/config.php');

// Obtén los datos JSON enviados
$id_paciente = $_GET['id_paciente'];
//es la fecha de la cita
$desde = $_GET['desde'];
$hora = $_GET['hora'];


if (isset($id_paciente) && isset($desde) && isset($hora)) {
    $sentencia1 = $pdo->prepare("SELECT * FROM tb_reservas 
    WHERE id_paciente = :id_paciente 
    AND fecha_cita = :desde 
    AND hora_cita = :hora
    AND realizada = 1");
    $sentencia1->execute([
        ':id_paciente' => $id_paciente,
        ':desde' => $desde,
        ':hora' => $hora
    ]); 
    $cuenta = $sentencia1->rowCount();

    if ($cuenta > 0) {
        try {
            $sentencia = $pdo->prepare("UPDATE tb_reservas 
            SET pagado = 1 
            WHERE id_paciente = :id_paciente 
            AND fecha_cita = :desde 
            AND hora_cita = :hora");
            $sentencia->execute([
                ':id_paciente' => $id_paciente,
                ':desde' => $desde,
                ':hora' => $hora
            ]);

            session_start();
            // Establecer mensaje de éxito en la sesión
            $_SESSION['mensaje'] = 'El pago fue registrado correctamente';
            $_SESSION['icono'] = 'success';

            // Redirigir al usuario después de la actualización
            echo '<script>location.href = "' . APP_URL . '/view/facturacion/index.php";</script>';
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        session_start();
        // Establecer mensaje de error en la sesión
        $_SESSION['mensaje'] = 'La cita aún no se encuentra confirmada';
        $_SESSION['icono'] = 'error';

        // Redirigir al usuario en caso de error
        echo '<script>location.href = "' . APP_URL . '/view/facturacion/index.php";</script>';
    }
}

