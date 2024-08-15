<?php
include_once('../config.php');

$id_paciente_valor = $_POST['id_paciente'];
$id_valor = $_POST['id_valor'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$precio = $_POST['precio'];
$estado = 1;
$fechaHora = $fechaHora; // Assuming you want to capture the current date and time

// Prepare the SQL statement
$sentencia = $pdo->prepare("
    UPDATE tb_valores SET 
    id_paciente_valor = :id_paciente_valor,
    desde = :desde,
    hasta = :hasta,
    precio = :precio,
    fyh_actualizacion = :fyh_actualizacion,
    estado = :estado
    WHERE id_valor = :id_valor
");

$sentencia->bindParam(':id_valor', $id_valor);
$sentencia->bindParam(':id_paciente_valor', $id_paciente_valor);
$sentencia->bindParam(':desde', $desde);
$sentencia->bindParam(':hasta', $hasta);
$sentencia->bindParam(':precio', $precio); // Corrected 'pecio' to 'precio'
$sentencia->bindParam(':fyh_actualizacion', $fechaHora);
$sentencia->bindParam(':estado', $estado);

session_start();

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = 'El Valor se actualizó de la manera correcta';
    $_SESSION['icono'] = 'success';
} else {
    $_SESSION['mensaje'] = 'Los datos no se pudieron actualizar';
    $_SESSION['icono'] = 'error';
}

?>
<script>
    location.href = "<?php echo APP_URL; ?>/view/valores/index.php";
</script>
<?php
?>
