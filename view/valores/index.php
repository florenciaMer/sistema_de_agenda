<?php 
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/valores/listado_de_consultas.php');
?>

</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Valores de las Consultas</h1>
            </div>
            <div class="row">
            <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Cosultas registradas</h3>
                    <a href="create.php" class="btn btn-primary">Crear Valor</a>
                </div>

                <table class="table border" id="example2">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Valor</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                     <?php
                     
                        $contador_valores=0;
                            foreach ($valores_datos as $valor) {
                                $contador_valores = $contador_valores+1;
                                $id_paciente = $valor['id_paciente_valor'];
                                $desde = $valor['desde'];
                                $hasta = $valor['hasta'];
                                $fyh_creacion = $valor['fyh_creacion'];
                                $precio = $valor['precio'];
                                $id_valor = $valor['id_valor'];
                                
                                foreach ($datos_paciente as $paciente) {
                                  if ($id_paciente == $paciente['id_paciente']) {
                                      $nombre = $paciente['nombre'];
                                      $apellido = $paciente['apellido'];
                                     
                                  }
                          
                              }  
                           ?>
                           
                        <tr>

                            <td><?php echo $contador_valores?></td>
                           
                            <td><?php echo $nombre?></td>
                            <td><?php echo $apellido?></td>
                            <td>$<?php echo $precio?></td>
                            <td><?php echo date('d-m-Y', strtotime($desde));?></td>
                            <td><?php echo date('d-m-Y', strtotime($hasta));?></td>
                          
                
                            <td>
                             <!--   <a href="show.php?id_usuario=<?php echo $id_paciente;?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a> -->
                                <a href="update.php?id_valor=<?php echo $id_valor;?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                
                           <span id="btn-delete<?php echo $id_valor?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></span>
                            </td>
                            <div id="respuesta-delete<?php echo $id_valor?>"></div>
<script>
$('#btn-delete<?php echo $id_valor;?>').click(function(){

let id_valor =  '<?php echo $id_valor?>';

Swal.fire({
  title: '¿Está seguro de eliminar los valores de <?php echo $nombre .' - '. $apellido?>?',
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
    let desde = "<?php echo $desde;?>";
    let hasta = "<?php echo $hasta;?>";
    let id_paciente = "<?php echo $id_paciente;?>";
    let url = "<?php echo APP_URL;?>/controllers/valores/delete.php";
        $.get(url, {id_paciente: id_paciente, id_valor: id_valor, desde:desde, hasta:hasta}, function(datos){
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

<!-- Control Sidebar -->
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');
?>
<script>
  $(function () {
    $("#example2").DataTable({
      "pageLength": 5,
    "language":{
      "emptyTable": "No hay información",
      "info": "Mostrando_START_a _END_de_Total_valores",
      "infoEmpty":"Mostrando 0 a 0 de 0 valores",
      "infoFiltered":"(Filtrado de _MAX_ total valores)",
      "infoPostFix": "",
      "thousands":",",
      "lengthMenu": "Mostrar _MENU_valores",
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