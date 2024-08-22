<?php
include_once('../config.php');

$titulo = $_GET['titulo'];

$sql = "SELECT realizada FROM tb_reservas WHERE title = :titulo";
$query = $pdo->prepare($sql);
$query->bindParam(':titulo', $titulo);
$query->execute();

$realizado = $query->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontró un resultado
if ($realizado) {
    echo trim($realizado['realizada']); // Eliminar espacios en blanco por si acaso
} else {
    echo 'Error: No se encontró la realización en la base de datos';
}