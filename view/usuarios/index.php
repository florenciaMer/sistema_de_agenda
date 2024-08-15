<?php 
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/usuarios/listado_de_usuarios.php');
?>

</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Usuarios</h1>
            </div>
            <div class="row">
            <div class="card">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Usuarios registrados</h3>
                   <!-- <a href="create.php" class="btn btn-primary">Crear Usuario</a> -->
                </div>

                <table class="table border" id="example2">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Email</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                     <?php
                        $contador_usuarios=0;
                            foreach ($usuarios_datos as $usuario) {
                                $contador_usuarios = $contador_usuarios+1;
                                $id_usuario = $usuario['id_usuario'];
                                $email = $usuario['email'];
                                $fecha_creacion = $usuario['fyh_creacion'];
                            
                           ?>
                        <tr>
                            <td><?php echo $contador_usuarios?></td>
                            <td><?php echo $email?></td>
                            <td><?php echo $fecha_creacion?></td>
                         
                            <td>
                             <!--   <a href="show.php?id_usuario=<?php echo $id_usuario;?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a> -->
                                <a href="update.php?id_usuario=<?php echo $id_usuario;?>" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                <button id="btn-delete<?php echo $id_usuario;?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                            <div id="respuesta-delete<?php echo $id_usuario?>"></div>
                            <script>
$('#btn-delete<?php echo $id_usuario;?>').click(function(){

let id_usuario =  '<?php echo $id_usuario?>';

Swal.fire({
  title: '¿Está seguro de eliminar al usuario <?php echo $email?>?',
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
    
    let url = "<?php echo APP_URL;?>/controllers/usuarios/delete.php";
        $.get(url, {id_usuario: id_usuario}, function(datos){
         $('#respuesta-delete<?php echo $id_usuario?>').html(datos);
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
