<?php
include_once('../config.php');
session_start(); // Iniciar la sesión

// Verifica si la solicitud es una llamada POST para actualizar la sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos JSON enviados por la llamada AJAX
    $data = json_decode(file_get_contents('php://input'), true);

    // Verifica que 'realizada' esté en los datos recibidos
    if (isset($data['realizada'])) {
        // Asigna el valor a la sesión
        $_SESSION['realizada'] = $data['realizada'];
        // Enviar una respuesta exitosa
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        // Enviar una respuesta de error si 'realizada' no está en los datos
        echo json_encode(['status' => 'error', 'message' => 'No se recibió el valor de realizada']);
        exit;
    }
}

// Si no es una solicitud POST, manejar la recuperación de datos
try {
    // Realiza la consulta SQL
    $sql = "SELECT title, start, end, backgroundColor, borderColor, hora_cita, realizada
     FROM tb_reservas WHERE estado='1'";
    $query = $pdo->prepare($sql);
    $query->execute();

    $reservas = $query->fetchAll(PDO::FETCH_ASSOC);

    // Procesar los datos antes de convertirlos a JSON
    foreach ($reservas as $reserva) { // Usar referencia para modificar directamente el array
        // Asegurarse de que los valores sean correctos y no contengan caracteres problemáticos
        $reserva['title'] = htmlspecialchars($reserva['title'], ENT_QUOTES, 'UTF-8');
        $reserva['start'] = htmlspecialchars($reserva['start'], ENT_QUOTES, 'UTF-8');
        $reserva['end'] = htmlspecialchars($reserva['end'], ENT_QUOTES, 'UTF-8');
        $reserva['realizada']= htmlspecialchars($reserva['realizada'], ENT_QUOTES, 'UTF-8');
        // Otros campos si es necesario...
    }
    unset($reserva); // Desvincular referencia

    // Convertir a JSON y devolver la respuesta
    echo json_encode($reservas, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}
?>
