<?php
include_once('../../controllers/config.php');

// Obtén los datos JSON enviados
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$desde = $_SESSION['desde'] ;
$hasta = $_SESSION['hasta'] ;
// Debugging: Verifica los datos recibidos
file_put_contents('php://stderr', print_r($data, TRUE));

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

        $sentencia= $pdo->prepare("SELECT * FROM tb_reservas
        WHERE id_paciente = :id_paciente
       AND fecha_cita >= :desde
       AND fecha_cita <= :hasta
       AND pagado = '0'
       AND estado = '1'");
      
      $sentencia->bindParam(':desde', $desde);
      $sentencia->bindParam(':hasta', $hasta);
      $sentencia->bindParam(':id_paciente', $id_paciente);
      
       $sentencia->execute();
       
      
           session_start();
        $_SESSION['citas_a_facturar_datos'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($_SESSION['citas_a_facturar_datos'] as $citas_a_facturar) {
          $_SESSION['id_paciente'] = $citas_a_facturar['id_paciente'];
          $_SESSION['fecha_cita'] = $citas_a_facturar['fecha_cita'];
          $_SESSION['hora_cita'] = $citas_a_facturar['hora_cita'];
          $_SESSION['estado'] = $citas_a_facturar['estado'];
          $_SESSION['pagado'] = $citas_a_facturar['pagado'];
          $_SESSION['title'] = $citas_a_facturar['title'];
          $_SESSION['fyh_creacion'] = $citas_a_facturar['fyh_creacion'];
          $_SESSION['desde'] = $desde;
          $_SESSION['hasta'] = $hasta;
      }
          

        
        // Mensaje de éxito
        echo 'Pagos registrados correctamente.';
        session_start();
        $_SESSION['mensaje'] = 'Los pagos fueron registrados correctamente';
        $_SESSION['icono'] = 'success';
        header('Location:'.APP_URL.'/view/facturacion/datos_facturacion_paciente.php');
       
    } catch (Exception $e) {
        // Revierte la transacción en caso de error
        $pdo->rollBack();
        echo 'Error al registrar los pagos: ' . $e->getMessage();
    }
} else {
    echo 'No se registraron datos en la cita.';
}
?>
