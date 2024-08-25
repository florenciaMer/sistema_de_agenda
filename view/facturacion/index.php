<?php 
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../../controllers/facturacion/listado_de_facturaciones.php');
include_once('../../controllers/facturacion/listado_de_citas.php')
?>
</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Citas</h1>
            </div>
            <div class="row">
            <div class="card col-md-10">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Citas registradas </h3>
                    <a href="create.php" class="btn btn-primary">Facturar por paciente</a>
                </div>
              
                <table id="example2" class="table table-striped">
              
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th> <!--realizada o no-->
                            <th>Precios - Acción</th>
                            <th>Pago - Acción</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <!-- SE DEJA PENDIENTE EL CODIGO HASTA TENER REGISTRADAS LAS FACTURACIONES-->
                     <?php
                        $total = 0;
                        $contador_citas=0;
                            foreach ($citas_datos as $cita) {
                                $contador_citas = $contador_citas+1;
                                $id_paciente = $cita['id_paciente'];
                                $desde = $cita['fecha_cita'];
                                $hora = $cita['hora_cita'];
                                $pagado = $cita['pagado'];
                                $precio = $cita['precio'];
                                //$total += $precio;
                               // echo $total;
                              
                                foreach ($pacientes_datos as $paciente) {
                                  if ($id_paciente == $paciente['id_paciente']) {
                                      $nombre = $paciente['nombre'];
                                      $apellido = $paciente['apellido'];
                                     break;
                                  }
                              }  
                           ?>
                           
                        <tr>

                            <td><?php echo $contador_citas?></td>
                           
                            <td><?php echo $nombre?></td>
                            <td><?php echo $apellido?></td>
                            <td><?php echo date('d-m-Y', strtotime($desde));?></td>
                            <td><?php echo $hora;?></td>
                            
                           <!-- <td>$<?php echo $total;?></td> -->
                            <?php if ($cita['realizada'] == '1') {
                              ?>
                              <td class="bg-success">Confirmada</td>
                           <?php }else{?>

                             <td class="bg-warning">Sin Confirmar</td>
                           <?php } ?>
                           
                            <!-- valida si tiene lista de precio asociada accion -->
                            <?php if ($cita['precio'] === 'not_precio') {
                              ?>
                              <td>
                              Sin Lista de precios 
                              <form action="../valores/create_para_un_paciente.php" method="post">
                              <input type="hidden" name="id_paciente" value="<?php echo $id_paciente; ?>">
                              <button type="submit" class="btn btn-primary btn-sm cargar-precio" id="cargar-precio<?php echo $id_paciente;?>">
                                  Cargar precio
                                  <i class="bi bi-pencil"></i>
                                </button>
                              </button>
                            </td>
                            <?php }else{?>
                              <td style="text-align: center;">$<?php echo $cita['precio'];?></td>

                             
                          </form>
                              <?php }?>
                           <!-- pago accion -->
                           <?php if ($cita['pagado'] == '1') {
                              ?>
                              <td>Paga</td>
                           <?php }else{?>

                             <td>
                              Sin Pagar 
                              <button class="btn btn-primary btn-sm confirmar-factura" 
                                  id="confirmar-factura<?php echo $id_paciente;?>" 
                                  data-id="<?php echo $id_paciente; ?>"
                                  data-desde="<?php echo urlencode($desde); ?>"
                                  data-hora="<?php echo date('H:i', strtotime($hora)); ?>">

                            Facturar
                            <i class="bi bi-pencil"></i>
                          </button>
                            </td>
          
          
                           <?php } ?>
                
                           <!-- <td>
                                <a href="show.php?id_usuario=<?php echo $id_paciente;?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a> 
                                <a href="update.php?id_valor=<?php echo $id_valor;?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a> 
                                <button id="btn-delete<?php echo $id_valor;?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button> 
                            </td>
                           <div id="respuesta-delete<?php echo $id_valor?>"></div>-->
      

                        <?php  }?>
                           <div id="respuesta-facturar" ></div>

                     
                        </tr>
                    </tbody>
                </table>
               </div>
            </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]
    });
})
  
$(function () {
    $("#example2").DataTable({
      "pageLength": 5,
    "language":{
      "emptyTable": "No hay información",
      "info": "Mostrando_START_a _END_de_Total_Pacientes",
      "infoEmpty":"Mostrando 0 a 0 de 0 Pacientes",
      "infoFiltered":"(Filtrado de _MAX_ total Pacientes)",
      "infoPostFix": "",
      "thousands":",",
      "lengthMenu": "Mostrar _MENU_Pacientes",
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
        collectionLayout: 'fixed three-column',
        
      }
    ],
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
  });
</script>

<script>
  $(document).ready(function() {
    // Usa una clase en lugar de un ID para manejar el clic en los botones
    $(document).on('click', '.btn.confirmar-factura', function() {
        var id_paciente = $(this).data('id');
        //desde es la fecha de la cita
        var desde = $(this).data('desde');
        var hora = $(this).data('hora');

        // Imprime los datos en la consola para verificar
        console.log('ID Paciente:', id_paciente);
        console.log('Desde:', desde);
        console.log('Hora:', hora);

    
    let url = "<?php echo APP_URL;?>/controllers/facturacion/pagar_una_cita.php";
        $.get(url, {id_paciente: id_paciente, desde:desde, hora:hora}, function(datos){
         $('#respuesta-facturar').html(datos);
        });
  })
 
  })
</script>

<!-- Control Sidebar -->
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');
?>
