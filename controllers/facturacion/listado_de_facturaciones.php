<?php

//include_once('../config.php');

$sql = "SELECT * FROM tb_facturacion order by desde desc";
$query = $pdo->prepare($sql);
$query->execute();

$facturaciones_datos = $query->fetchAll(PDO::FETCH_ASSOC);
?>