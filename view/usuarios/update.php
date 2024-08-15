<?php 
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');

$id_usuario = $_GET['id_usuario'];

include_once('../../controllers/usuarios/buscar_datos_usuario.php');
?>

</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Actualizar un usuario</h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Completa los campos</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo APP_URL; ?>/controllers/usuarios/update.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required value="<?php echo $email; ?>">
                                        <input type="hidden" id="id_usuario" name="id_usuario" class="form-control" value="<?php echo $id_usuario; ?>">
                                    </div>
                                </div>
                               
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id="password_user" name="password_user" class="form-control" required value="<?php echo $password_user;?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Repetir password</label>
                                        <input type="password" id="password_repeat" name="password_repeat" class="form-control" required value="<?php echo $password_user;?>">
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                        <a href="<?php echo APP_URL;?>/view/usuarios" type="button" class="btn btn-secondary">Cancelar</a>
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
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');

 ?>
   