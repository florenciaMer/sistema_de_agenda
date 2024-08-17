<?php

//include_once('../config.php');

$sql = "SELECT * FROM tb_reservas WHERE estado = '1' AND pagado = '0'
ORDER BY fecha_cita DESC";
$query = $pdo->prepare($sql);
$query->execute();

$citas_datos = $query->fetchAll(PDO::FETCH_ASSOC);
?>