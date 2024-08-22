<?php
include_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
   
    $backgroundColor = $_POST['backgroundColor'];
    $borderColor = $_POST['borderColor'];

    $sql = "UPDATE tb_reservas SET backgroundColor = :backgroundColor, borderColor = :borderColor
     WHERE title = :titulo";
    $query = $pdo->prepare($sql);
    $query->bindParam(':backgroundColor', $backgroundColor);
    $query->bindParam(':borderColor', $borderColor);
    $query->bindParam(':titulo', $titulo);
    
    session_start();
    $_SESSION['realizada'] = '1';

    if ($query->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}