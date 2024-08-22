<?php 
include_once('../../controllers/config.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../layout/parte1.php');
$id_paciente_post = $_POST['id_paciente'];
echo $id_paciente_post;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo APP_NAME?> | Cargar valores para un paciente</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo APP_URL?>/public/adminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo APP_URL?>/public/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo APP_URL?>/public/adminLTE/dist/css/adminlte.min.css">

  
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js
    "></script>
</head>
<body class="hold-transition login-page">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Registro de Valores por Paciente</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo APP_URL; ?>/controllers/valores/create.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="class form-group d-flex">
                                        
                                        <label for="id_paciente">Paciente:</label>
                                        <div class="col-md-8">
                                           
                                        <?php $nombreCompleto = ''; // Inicializa una variable para el nombre completo

                                        // Recorre los datos de los pacientes para encontrar el nombre y apellido
                                        foreach ($pacientes_datos as $paciente) {
                                            if ($paciente['id_paciente'] == $id_paciente_post) {
                                                $nombreCompleto = $paciente['nombre'] . ' ' . $paciente['apellido'];
                                                break; // Detén el bucle una vez encontrado el paciente correcto
                                            }
                                        }
                                        ?>

                                        <!-- Luego, usa esta variable para mostrar el nombre completo en el input -->
                                        <input type="text" class="form-control" name="nombre_apellido" value="<?php echo $nombreCompleto; ?>">
                                        <input type="hidden" class="form-control" name="id_paciente" value="<?php echo $id_paciente_post; ?>">
                                                                                    
                                        </div>
                                        <div class="col-md-4">
                                            <a href="<?php echo APP_URL;?>/view/pacientes/create.php" class="btn btn-primary"><i class="fa fa-plus"></i></a>             
                                        </div>
                                       
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Desde</label>
                                        <input type="date" id="desde" name="desde" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Hasta</label>
                                        <input type="date" id="hasta" name="hasta" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio">Precio</label>
                                        <input type="text" id="precio" name="precio" class="form-control" required>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                        <a href="#" type="button" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
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
<?php 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');

 ?>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    var desdeInput = document.getElementById('desde');
    var hastaInput = document.getElementById('hasta');

    desdeInput.addEventListener('change', function() {
        // Get the selected date from 'desde'
        var desdeDate = new Date(desdeInput.value);

        // Set the 'min' attribute of 'hasta' to the selected date
        hastaInput.min = desdeInput.value;
        
        // Optionally clear the 'hasta' field if the selected date is after the current 'hasta' value
        if (hastaInput.value && new Date(hastaInput.value) < desdeDate) {
            hastaInput.value = '';
        }
    });
});
</script>
