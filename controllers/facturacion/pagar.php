<?php
include_once('../../controllers/config.php');

// Obtén los datos JSON enviados
$input = file_get_contents('php://input');
$data = json_decode($input, true);
session_start();
$desde = $_SESSION['desde'];
$hasta = $_SESSION['hasta'];

// Debugging: Verifica los datos recibidos (esto puede eliminarse en producción)
file_put_contents('php://stderr', print_r($data, TRUE));

header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

if (isset($data['id_paciente']) && isset($data['citas'])) {
    $id_paciente = $data['id_paciente'];
    $citas = $data['citas'];

    // Prepara la consulta SQL para actualizar registros
    $sql = "UPDATE tb_reservas 
            SET pagado = 1 
            WHERE id_paciente = :id_paciente 
            AND fecha_cita = :fecha_cita 
            AND hora_cita = :hora_cita";

    try {
        // Inicia la transacción
        $pdo->beginTransaction();
        $stmt = $pdo->prepare($sql);

        foreach ($citas as $cita) {
            $stmt->execute([
                ':id_paciente' => $id_paciente,
                ':fecha_cita' => $cita['fecha_cita'],
                ':hora_cita' => $cita['hora_cita']
            ]);
        }

        // Confirma la transacción
        $pdo->commit();

        // Obtener citas pendientes de pago
        $sentencia = $pdo->prepare("SELECT * FROM tb_reservas
            WHERE id_paciente = :id_paciente
            AND fecha_cita >= :desde
            AND fecha_cita <= :hasta
            AND pagado = '0'
            AND estado = '1'");
        
        $sentencia->bindParam(':desde', $desde);
        $sentencia->bindParam(':hasta', $hasta);
        $sentencia->bindParam(':id_paciente', $id_paciente);
        $sentencia->execute();

        $_SESSION['citas_a_facturar_datos'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
      
        // Establecer mensaje de éxito en la sesión
        $_SESSION['mensaje'] = 'Los pagos fueron registrados correctamente';
        $_SESSION['icono'] = 'success';

        // Enviar la respuesta JSON con la URL de redirección
        echo json_encode([
            'status' => 'success',
            'redirect_url' => APP_URL . '/view/facturacion/index.php'
        ]);
        exit();
    } catch (Exception $e) {
        // Revierte la transacción en caso de error
        $pdo->rollBack();

        echo json_encode([
            'status' => 'error',
            'message' => 'Error al registrar los pagos: ' . $e->getMessage()
        ]);
        exit();
    }
} else {
    // En caso de que no se reciban los datos correctos
    $_SESSION['mensaje'] = 'No se registraron datos en la cita';
    $_SESSION['icono'] = 'error';

    echo json_encode([
        'status' => 'error',
        'message' => 'Datos insuficientes para procesar la solicitud.'
    ]);
    exit();
}
?>
