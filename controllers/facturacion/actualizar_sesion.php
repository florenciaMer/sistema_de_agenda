<?php
// Inicia la sesión al principio del archivo
include_once('../config.php');
session_start();

// Obtiene el contenido del POST
$input = file_get_contents('php://input');

// Decodifica el JSON recibido
$data = json_decode($input, true);

// Verifica si los datos fueron recibidos correctamente
if (isset($data['titulo'])) {
    $titulo = $data['titulo'];

    // Configura la conexión a la base de datos
    try {
        
        // Prepara la consulta SQL utilizando parámetros
        $sql_check = "SELECT * FROM tb_reservas WHERE title = :titulo";
        $sentencia = $pdo->prepare($sql_check);
        $sentencia->bindParam(':titulo', $titulo, PDO::PARAM_STR);

        // Ejecuta la consulta
        $sentencia->execute();

        // Obtiene el número de filas devueltas
        $cuenta = $sentencia->rowCount();

        if ($cuenta > 0) {
            $realizada = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            foreach ($realizada as $valor) {
                $_SESSION['realizada'] = $valor['realizada'];
            }

            // Responde con un mensaje de éxito
            echo json_encode(['status' => 'success', 'message' => 'Sesión actualizada']);
        } else {
            // Responde con un mensaje de error
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron datos']);
        }

    } catch (PDOException $e) {
        // Maneja errores de conexión a la base de datos
        echo json_encode(['status' => 'error', 'message' => 'Error en la conexión a la base de datos: ' . $e->getMessage()]);
    }

} else {
    // Responde con un mensaje de error si no se recibió el título
    echo json_encode(['status' => 'error', 'message' => 'No se recibió el título']);
}
?>
