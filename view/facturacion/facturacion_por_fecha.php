<?php 
include_once('../../controllers/config.php');
include_once('../layout/parte1.php');
include_once('../../controllers/pacientes/listado_de_pacientes.php');
include_once('../../controllers/facturacion/listado_de_facturaciones.php');
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
                    <h3>Citas registradas para un período </h3>
                    <a href="create.php" class="btn btn-primary">Facturar</a>
                </div>
                <div class="row form-group">
                <label for="fecha_desde">Desde</label>
                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control w-25 ml-2">
             
                  <label for="fecha_hasta" class="ml-2">Hasta</label>
                  <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control w-25 ml-2">
                  <div id="btn-buscar-fecha" class="btn btn-primary ml-3 w-25"><i class="bi bi-search m-1"></i>Buscar</div> 
                </div>
                
               
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Realizada</th>
                            <th>Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se insertarán las filas -->
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
      

  document.addEventListener('DOMContentLoaded', function() {
    var desdeInput = document.getElementById('fecha_desde');
    var hastaInput = document.getElementById('fecha_hasta');

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

<script>
  //$(document).on('click', '#btn-buscar-fecha', function() {
 // $('#btn-buscar-fecha').click(function() {
 
 //let fecha_desde = $('#fecha_desde').val();
 //   let fecha_hasta = $('#fecha_hasta').val();
    /*let data = {         
        
        desde: fecha_desde,
        hasta: fecha_hasta,
    };*/
    //console.log('Datos enviados:', JSON.stringify(data)); // Verifica los datos que se están enviando


    $(document).on('click', '#btn-buscar-fecha', function() {
    let fecha_desde = $('#fecha_desde').val();
    let fecha_hasta = $('#fecha_hasta').val();
    /*let data = {         
        desde: fecha_desde,
        hasta: fecha_hasta,
    };*/
    
    //console.log('Datos enviados:', JSON.stringify(data)); // Verifica los datos que se están enviando

    let url = "<?php echo APP_URL;?>/controllers/facturacion/citas_en_una_fecha.php";
    $.get(url, { desde: fecha_desde, hasta: fecha_hasta }, function(response) {
    if ($('#example2 tbody').length) {
        if ($.fn.DataTable.isDataTable('#example2')) {
            $('#example2').DataTable().clear().destroy();
        }

        // Procesa el HTML recibido
        let htmlContent = response.html;
        let parsedHTML = $.parseHTML(htmlContent);

        // Insertar HTML directamente en el tbody
        $('#example2 tbody').empty().append(parsedHTML);

        $(function () {
    $("#example2").DataTable({
      "pageLength": 5,
    "language":{
      "emptyTable": "No hay información",
      "info": "Mostrando_START_a _END_de_Total_Resultados",
      "infoEmpty":"Mostrando 0 a 0 de 0 Resultados",
      "infoFiltered":"(Filtrado de _MAX_ total Resultados)",
      "infoPostFix": "",
      "thousands":",",
      "lengthMenu": "Mostrar _MENU_Resultados",
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
    } else {
        console.error('El tbody con id #example2 no existe en el DOM');
    }
}, 'json');

    })
  
  
</script>
<!-- Control Sidebar -->
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');
?>
<script>
    
</script>