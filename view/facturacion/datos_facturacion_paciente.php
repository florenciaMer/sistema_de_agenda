<?php
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../../controllers/facturacion/listado_de_facturaciones.php');
include_once('../../controllers/facturacion/listado_de_citas.php');
// include_once('../../controllers/facturacion/buscar_citas_facturar.php');

// Debugging session data
if (isset($_SESSION['citas_a_facturar_datos']) && !empty($_SESSION['citas_a_facturar_datos'])) {
    $citas_a_facturar_datos = $_SESSION['citas_a_facturar_datos'];
    $total = 0;
    $contador_citas = 0;
    $id_paciente = $citas_a_facturar_datos[0]['id_paciente'];

    $sql_paciente = "SELECT nombre, apellido FROM tb_pacientes
                      WHERE id_paciente = :id_paciente
                      AND estado = '1'";

    $sentencia3 = $pdo->prepare($sql_paciente);
    $sentencia3->bindParam(':id_paciente', $id_paciente);
    $sentencia3->execute();
    $paciente_datos = $sentencia3->fetch(PDO::FETCH_ASSOC);
    $nombre = $paciente_datos['nombre'];
    $apellido = $paciente_datos['apellido'];

    echo '<div class="content-wrapper"><br><div class="content"><div class="container">
    <div class="row"><h3>Información de Facturación por paciente</h3></div><div class="row">
    <div class="card">
    <div class="card-body">
    <table class="table border" id="example2">
    <thead>
    <tr>
    <th>Nro</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Importe</th>
    <th>Estado</th>
    </tr>
    </thead>
    <tbody>';

foreach ($citas_a_facturar_datos as $citas_a_facturar) {
    $contador_citas++;
    $id_paciente = $citas_a_facturar['id_paciente'];
    $fecha_cita = $citas_a_facturar['fecha_cita'];
    $hora_cita = $citas_a_facturar['hora_cita'];
    $pagado = $citas_a_facturar['pagado'];

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
                <a href="../valores/create.php" class="btn btn-primary" id="facturar">Crear Lista</a>
                <?php
            }
            ?>
        </td>
        <?php
          if ($pagado == '1') {?>
            <td>Pagado</td>
          <?php }else if($pagado == '0') {?>
            <td>Impago</td>
        <?php  } ?>
       
      
    </tr>
    <div id="pagar"></div>
    <?php
}

echo '</tbody></table>';
echo '<div class="rounded" style="text-align: right; background-color:darkgray; padding:5px;margin: 10px;">Total: $' . number_format($total, 2) . '</div>';
echo  '<div style="text-align: right; margin-top: 10px;" >
<div id="btn-facturar" class="btn btn-success">Confirmar Pago</div>
</div>';

echo '</div></div></div></div></div>';

     ?>
    
<?php } else{
  echo "Sin datos para mostrar en la vista";
}
'</div></div>'?>
<script>

$('#btn-facturar').click(function(){
    let citas_a_facturar_datos = <?php echo json_encode($citas_a_facturar_datos); ?>;
    let id_paciente = '<?php echo $id_paciente ?>';
    
    // Crea el objeto de datos a enviar
    let data = {         
        id_paciente: id_paciente,
        citas: citas_a_facturar_datos
    };

    // Enviar los datos al servidor usando POST
    $.ajax({
        url: "<?php echo APP_URL; ?>/controllers/facturacion/pagar.php",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            // Maneja la respuesta del servidor aquí
            console.log('Respuesta del servidor:', response); // Para depuración
            $('#pagar<?php echo $id_paciente ?>').html(response);
        },
        error: function(xhr, status, error) {
            // Maneja errores aquí
            console.error('Error:', error);
        }
    });
});
</script>

        
 </script>
  
<script>
  $(function () {
    $("#example2").DataTable({
      "pageLength": 5,
    "language":{
      "emptyTable": "No hay información",
      "info": "Mostrando_START_a _END_de_Total_resultados",
      "infoEmpty":"Mostrando 0 a 0 de 0 resultados",
      "infoFiltered":"(Filtrado de _MAX_ total resultados)",
      "infoPostFix": "",
      "thousands":",",
      "lengthMenu": "Mostrar _MENU_resultados",
      "loadingRecords": "Cargando...",
      "processing":"Procesando",
      "search": "Buscador",
      "zeroRecords": "Sin resultados encontrados",
      "paginate":{
        "first":"Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
        }
      },
      "responsive": true, "lengthChange": true, "autoWidth": false,
      buttons:[{
      extend:'collection',
      text: 'Reportes',
      orientation: 'landscape',
      buttons:[{
        text: 'Copiar',
        extend: 'copy',
      },{
        extend: 'pdf',
      },
      {
        extend: 'csv',
      },
      {
        extend: 'excel',
      },{
        text: 'Imprimir',
        extend: 'print',
      }]
    },
      {
        extend: 'colvis',
        text: 'Visor de columnas',
        collectionLayout: 'fixed three-column'
      }
    ],
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
  });
</script>
<!-- Control Sidebar -->
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');
?>


  

