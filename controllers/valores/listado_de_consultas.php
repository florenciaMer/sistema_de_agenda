<?php

//include_once('../config.php');

$sql = "SELECT tb_valores.*, tb_pacientes.nombre, tb_pacientes.apellido
FROM tb_valores
INNER JOIN tb_pacientes ON tb_valores.id_paciente_valor = tb_pacientes.id_paciente
WHERE tb_valores.estado = '1'
ORDER BY tb_pacientes.nombre, tb_valores.desde";
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