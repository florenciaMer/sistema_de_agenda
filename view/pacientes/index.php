<?php 
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
?>

</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Pacientes</h1>
            </div>
            <div class="row">
            <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Pacientes registrados</h3>
                    <a href="create.php" class="btn btn-primary">Crear Paciente</a>
                </div>

                <table class="table border" id="example2">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                     <?php
                        $contador_pacientes=0;
                            foreach ($pacientes_datos as $paciente) {
                                $contador_pacientes = $contador_pacientes+1;
                                $id_paciente = $paciente['id_paciente'];
                                $nombre = $paciente['nombre'];
                                $apellido = $paciente['apellido'];
                                $direccion = $paciente['direccion'];
                                $telefono = $paciente['telefono'];
                                $celular = $paciente['celular'];
                                $email = $paciente['email'];
                                $estado = $paciente['estado'];
                                $fecha_creacion = $paciente['fyh_creacion'];
                            
                           ?>
                        <tr>
                            <td><?php echo $contador_pacientes?></td>
                            <td><?php echo $nombre?></td>
                            <td><?php echo $apellido?></td>
                            <td><?php echo $direccion?></td>
                            <td><?php echo $telefono?></td>
                            <td><?php echo $celular?></td>
                            <td><?php echo $email?></td>
                            <td><?php echo $fecha_creacion?></td>
                
                            <td>
                             <!--   <a href="show.php?id_usuario=<?php echo $id_paciente;?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a> -->
                                <a href="update.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                <button id="btn-delete<?php echo $id_paciente;?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                            <div id="respuesta-delete<?php echo $id_paciente?>"></div>
      
<script>
$('#btn-delete<?php echo $id_paciente;?>').click(function(){

let id_paciente =  '<?php echo $id_paciente?>';

Swal.fire({
  title: '¿Está seguro de eliminar al paciente <?php echo $nombre .'-'. $apellido?>?',
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
    
    let url = "<?php echo APP_URL;?>/controllers/pacientes/delete.php";
        $.get(url, {id_paciente: id_paciente}, function(datos){
         $('#respuesta-delete<?php echo $id_paciente?>').html(datos);
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
        collectionLayout: 'fixed three-column'
      }
    ],
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
  });
</script>