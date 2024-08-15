<?php

//include_once('../config.php');
$id_valor_get = $_GET['id_valor'];

$sql = "SELECT * FROM `tb_valores` WHERE id_valor = '$id_valor_get' AND estado= '1'";
$query = $pdo->prepare($sql);
$query->execute();


$valores_datos = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($valores_datos as $valor) {
    $id_valor = $valor['id_valor'];
    $id_paciente_valor = $valor['id_paciente_valor'];
    $desde = $valor['desde'];
    $hasta = $valor['hasta'];
    $precio = $valor['precio'];
    $fyh_creacion = $valor['fyh_creacion'];

    echo $id_paciente_valor;
$sql2 = "SELECT * FROM tb_pacientes WHERE id_paciente = '$id_paciente_valor'";
$query2 = $pdo->prepare($sql2);
$query2->execute();

$datos_paciente = $query2->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos_paciente as $paciente) {
    $id_paciente = $paciente['id_paciente'];
    $nombre = $paciente['nombre'];
    $apellido = $paciente['apellido'];
    $email = $paciente['email'];
    $direccion = $paciente['direccion'];
    $telefono = $paciente['telefono'];
    $celular = $paciente['celular'];
}
    
}