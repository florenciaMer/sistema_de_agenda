<?php

include_once(dirname(__DIR__)."/controllers/config.php");

$id_usuario = $_GET['id_usuario'];

$sql_user = "SELECT * FROM tb_usuarios WHERE id_usuario = '$id_usuario'";
 $query_user = $pdo->prepare($sql_user);
 $query_user->execute();
 $usuarios_datos = $query_user->fetchAll(PDO::FETCH_ASSOC);
 $contador_usuario =0;

 foreach ($usuarios_datos as $dato) {
 $contador_usuario++;
    $id_usuario = $dato['id_usuario'];
    $email = $dato['email'];
    $estado = $dato['estado'];
    $fyh_creacion = $dato['fyh_creacion'];
    $password_user = $dato['password_user'];
 }
 
 ?>
