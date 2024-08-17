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
                <h1>Listado de Citas Por Cobrar</h1>
            </div>
            <div class="row">
            <div class="card col-md-10">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Citas registradas por cobrar</h3>
                    <a href="create.php" class="btn btn-primary">Facturar</a>
                </div>

                <table class="table border" id="example2">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                          
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
                                //$precio = $cita['precio'];
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
                          
                
                           <!-- <td>
                                <a href="show.php?id_usuario=<?php echo $id_paciente;?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a> 
                                <a href="update.php?id_valor=<?php echo $id_valor;?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a> 
                                <button id="btn-delete<?php echo $id_valor;?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button> 
                            </td>
                           <div id="respuesta-delete<?php echo $id_valor?>"></div>-->
      
<script>
$('#btn-delete<?php echo $id_valor;?>').click(function(){

let id_valor =  '<?php echo $id_valor?>';

Swal.fire({
  title: '¿Está seguro de eliminar la los valores de <?php echo $nombre .' - '. $apellido?>?',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: 'No',
  customClass: {
    actions: 'my-actions',
    cancelButton: 'order-1 right-gap',
    confirmButton: 'order-2',
    denyButton: 'order-3',
  },
}).then((result) => {
  if (result.isConfirmed) {
    
    let url = "<?php echo APP_URL;?>/controllers/valores/delete.php";
        $.get(url, {id_valor: id_valor}, function(datos){
         $('#respuesta-delete<?php echo $id_valor?>').html(datos);
        });
   
  } else if (result.isDenied) {
    Swal.fire('Los cambios no se guardaron', '', 'info')
  }
})
  
})

</script>
                        <?php  }?>
                            

                          
                     
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
