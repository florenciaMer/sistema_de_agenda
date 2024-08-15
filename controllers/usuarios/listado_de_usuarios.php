<?php
$sql = "SELECT * FROM tb_usuarios WHERE estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$usuarios_datos = $query->fetchAll(PDO::FETCH_ASSOC);