<?php 
include_once('../../controllers/config.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../layout/parte1.php');

$id_valor_get = $_GET['id_valor'];

include_once('../../controllers/valores/buscar_un_valor.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo APP_NAME?> | Edicion de un valor</title>

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
                            <h3 class="card-title">Edición de Valores por Paciente</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo APP_URL; ?>/controllers/valores/update.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="class form-group">
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <label for="id_paciente">Paciente:</label>
                                                <label>Nombre</label>
                                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre?>" disabled>
                                            </div> 
                                            <div class="col-md-6">
                                                <label>Apellido</label>
                                                <input type="hidden" id="id_paciente" name="id_paciente" class="form-control" value="<?php echo $id_paciente?>" required>
                                                <input type="hidden" id="id_valor" name="id_valor" class="form-control" value="<?php echo $id_valor?>" required>
                                                <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $apellido?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Desde</label>
                                        <input type="date" id="desde" name="desde" class="form-control" value="<?php echo $desde?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Hasta</label>
                                        <input type="date" id="hasta" name="hasta" class="form-control" value="<?php echo $hasta?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio">Precio</label>
                                        <input type="number" id="precio" name="precio" class="form-control" value="<?php echo $precio?>" required>
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
   