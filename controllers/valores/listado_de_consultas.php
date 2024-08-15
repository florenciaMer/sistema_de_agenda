<?php

//include_once('../config.php');

$sql = "SELECT * FROM tb_valores WHERE estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$valores_datos = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($valores_datos as $valor) {
    $id_valor = $valor['id_valor'];
    $id_paciente = $valor['id_paciente_valor'];
    $desde = $valor['desde'];
    $hasta = $valor['hasta'];
    $precio = $valor['precio'];
    $fyh_creacion = $valor['fyh_creacion'];

$sql2 = "SELECT * FROM tb_pacientes WHERE estado = '1'";
$query2 = $pdo->prepare($sql2);
$query2->execute();

$datos_paciente = $query2->fetchAll(PDO::FETCH_ASSOC);
    
}