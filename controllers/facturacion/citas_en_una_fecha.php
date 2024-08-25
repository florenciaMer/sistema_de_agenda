<?php
include_once('../../controllers/config.php');

// Verifica que la solicitud sea GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no permitido']);
    exit();
}

// Obtén los datos enviados en la solicitud GET
$desde = isset($_GET['desde']) ? $conn->real_escape_string($_GET['desde']) : '';
$hasta = isset($_GET['hasta']) ? $conn->real_escape_string($_GET['hasta']) : '';

// Verifica que todos los datos necesarios estén presentes
if (empty($desde) || empty($hasta)) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos necesarios']);
    exit();
}

// Construye la consulta SQL para citas
$sql_citas = "SELECT *
FROM tb_reservas
INNER JOIN tb_pacientes ON tb_reservas.id_paciente = tb_pacientes.id_paciente
WHERE fecha_cita BETWEEN '$desde' AND '$hasta'
AND tb_reservas.estado = '1';";
$result_citas = $conn->query($sql_citas);

if (!$result_citas) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la consulta de citas: ' . $conn->error]);
    exit();
}


// Construye el HTML para la respuesta
$html = '';
if ($result_citas->num_rows > 0) {
    while ($cita = $result_citas->fetch_assoc()) {
        
        
        $html .= "<tr>
                    <td>{$cita['nombre']}</td>
                    <td>{$cita['apellido']}</td>
                    <td>" . date('d-m-Y', strtotime($cita['fecha_cita'])) . "</td>
                    <td>{$cita['hora_cita']}</td>
                    <td>" . ($cita['realizada'] == 0 ? 'Sin realizar' : 'Realizada') . "</td>
                    <td>" . ($cita['pagado'] == 0 ? 'Impago' : 'Pago') . "</td>
                  </tr>";
    }
} else {
    $html = "<tr><td colspan='5'>No se encontraron citas</td></tr>";
}

// Devuelve la respuesta JSON
$response = [
    'status' => 'success',
    'html' => $html
];

header('Content-Type: application/json');
echo json_encode($response);

// Cierra la conexión
$conn->close();
?>
