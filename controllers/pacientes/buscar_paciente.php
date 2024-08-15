<?php

//include_once(dirname(__DIR__)."/config.php");
//include_once('../config.php');
$id_paciente_get = $_GET['id_paciente'];

$sql = "SELECT * FROM tb_pacientes WHERE id_paciente = '$id_paciente_get' AND estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$paciente_datos = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($paciente_datos as $paciente) {
    $nombre = $paciente['nombre'];
    $apellido = $paciente['apellido'];
    $direccion = $paciente['direccion'];
    $telefono = $paciente['telefono'];
    $celular = $paciente['celular'];
    $email = $paciente['email'];
    $fecha_creacion = $paciente['fyh_creacion'];
}