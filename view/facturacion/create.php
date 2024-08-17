<?php 
include_once('../../controllers/config.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../layout/parte1.php');
?>

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
                            <h3 class="card-title">Facturación por Paciente</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo APP_URL; ?>/controllers/facturacion/buscar_citas_facturar.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="class form-group d-flex">
                                        
                                        <label for="id_paciente">Paciente:</label>
                                        <div class="col-md-8">
                                                <select id="id_paciente" name="id_paciente" class="form-control">
                                                    <?php 
                                                    foreach ($pacientes_datos as $paciente) {
                                                        ?>
                                                        <option value="<?php echo $paciente['id_paciente'];?>">
                                                        <?php echo $paciente['nombre'];?>
                                                        </option>
                                                    <?php
                                                        }
                                                        ?>
                                                </select>
                                        </div>
                                       
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desde">Desde</label>
                                        <input type="date" id="desde" name="desde" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Hasta</label>
                                        <input type="date" id="hasta" name="hasta" class="form-control" required>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Buscar</button>
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
    