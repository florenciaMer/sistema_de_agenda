<?php

//include_once('../config.php');

$sql = "SELECT * FROM tb_pacientes WHERE estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$pacientes_datos = $query->fetchAll(PDO::FETCH_ASSOC);