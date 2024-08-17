<?php
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../../controllers/facturacion/listado_de_facturaciones.php');
include_once('../../controllers/facturacion/listado_de_citas.php');
//include_once('../../controllers/facturacion/buscar_citas_facturar.php');

// Debugging session data
if (isset($_SESSION['citas_a_facturar_datos']) && !empty($_SESSION['citas_a_facturar_datos'])) {
    $citas_a_facturar_datos = $_SESSION['citas_a_facturar_datos'];
    $total = 0;
    $contador_citas = 0;

    echo '<div class="content-wrapper"><br><div class="content"><div class="container"><div class="row"><h1>Información de Facturación por paciente</h1></div><div class="row"><div class="card">';

    foreach ($citas_a_facturar_datos as $citas_a_facturar) {
        $contador_citas++;
        $id_paciente = $citas_a_facturar['id_paciente'];
        $fecha_cita = $citas_a_facturar['fecha_cita'];
        $hora_cita = $citas_a_facturar['hora_cita'];
        $pagado = $citas_a_facturar['pagado'];

        // Debugging: Check the values being processed
        echo '<pre>'; print_r($citas_a_facturar); echo '</pre>';

        // Obtenemos el precio para cada cita
        $sql_check = "SELECT DISTINCT precio FROM tb_valores
                      WHERE id_paciente_valor = :id_paciente
                      AND :fecha_cita BETWEEN desde AND hasta
                      AND estado = '1'";

        $sentencia2 = $pdo->prepare($sql_check);
        $sentencia2->bindParam(':fecha_cita', $fecha_cita);
        $sentencia2->bindParam(':id_paciente', $id_paciente);
        $sentencia2->execute();
        $importe_datos = $sentencia2->fetch(PDO::FETCH_ASSOC);

        // Debugging: Check the result of the SQL query
        echo '<pre>'; print_r($importe_datos); echo '</pre>';

        echo '<div class="card-body"><table class="table border" id="example2"><thead><tr><th>Nro</th><th>Nombre</th><th>Apellido</th><th>Fecha</th><th>Hora</th><th>Importe</th></tr></thead><tbody>';
        ?>
        <tr>
            <td><?php echo $contador_citas; ?></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $apellido; ?></td>
            <td><?php echo date('d-m-Y', strtotime($fecha_cita)); ?></td>
            <td><?php echo $hora_cita; ?></td>
            <td>
                <?php 
                if ($importe_datos && isset($importe_datos['precio'])) {
                    $importe_unitario = $importe_datos['precio'];
                    $total += $importe_unitario;
                    echo '$' . number_format($importe_unitario, 2);
                } else {
                    echo "No hay lista asociada";
                    ?>
                    <a href="../valores/create.php" class="btn btn-primary">Crear Lista</a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
        echo '</tbody></table></div>';
    }

    echo '<div style="text-align: right; background-color:darkgray">Total: $' . number_format($total, 2) . '</div></div></div></div></div></div>';
}
?>
