<?php
include_once('../config.php');

$sql = "SELECT title, start, end, hora_cita FROM tb_reservas where estado='1'";
$query = $pdo->prepare($sql);
$query->execute();

$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
//print_r($resultado);

//lo convierto a json
echo json_encode($resultado);

?>