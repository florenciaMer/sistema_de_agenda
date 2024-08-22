<?php
include_once('../../controllers/config.php');

// Obtén los datos JSON enviados
$id_paciente = $_GET['id_paciente'];
//es la fecha de la cita
$desde = $_GET['desde'];
$hora = $_GET['hora'];



if ((isset($id_paciente) && isset($desde) && isset($hora) )) {
try{
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
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    }


        // Obtener citas pendientes de pago
        $sentencia2 = $pdo->prepare("SELECT * FROM tb_reservas
            WHERE  AND estado = '1'");
        
        session_start();
      
        // Establecer mensaje de éxito en la sesión
        $_SESSION['mensaje'] = 'El pago fué registrado correctamente';
        $_SESSION['icono'] = 'success';

        ?>
        <script> location.href = "<?php echo APP_URL; ?>/view/facturacion/index.php"</script>
        <?php 
    }

?>
