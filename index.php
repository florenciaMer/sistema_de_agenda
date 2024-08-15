<?php include_once('controllers/config.php');
include_once('view/layout/parte1.php');

include_once('controllers/pacientes/listado_de_pacientes.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas</title>
    <!---- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
 
 
    <script src="fullcalendar-6.1.15/dist/index.global.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row" style="margin-left: 3%;">
            <div class="col"></div>
            <div class="col-md-12 m-2">
                <h1>Reserva de Citas</h1>
             <div class="d-flex justify-content-center"> 
                <div id='calendar' class="w-100"></div>
             </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>

<script>

var a="";
var nombre="";
var apellido = "";
var hora="";
var fecha="";
var fecha_original="";
var fecha_inicial="";
var fechaInicioPrueba= "";
var nombreApellido="";
var titulo_evento="";

document.addEventListener('DOMContentLoaded', function() {

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    editable:true,
    selectable: true,
    allDaySlot: false,
   
     events:'controllers/reservas/cargar_reserva.php',
    
     dateClick: function(info, event) {
       a= info.dateStr //muestra la fecha del dia seleccionado
       const fechaComoCadena = a;
       var numeroDia = new Date(fechaComoCadena).getDay();
       var dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves','Viernes','Sabado', 'Domingo']
                {
                    $('#modal_reserva').modal("show");
                    $('#dia_de_la_semana').html(dias[numeroDia] + " " + a);
                    $('#fecha_cita').val(info.dateStr);
                   
                   var fecha_cita = info.dateStr;
             
                }
        },
       
       
        events:'controllers/reservas/cargar_reserva.php',
        
        eventClick:function(info){
       
            var cadena = info.event.title;
            var arrayCadena = cadena.split("-");
            for (let i = 0; i < 1; i++) {
              nombre = arrayCadena[1]
              apellido = arrayCadena[2]
              hora = arrayCadena[0]
              fecha = arrayCadena[3]
               nombreApellido = nombre + '-' + apellido
            }
           
             fecha = info.event.start;
             
             let year = fecha.getFullYear();
             let month = fecha.getMonth();
             month = month+1;
             let day = fecha.getDate();
             
             fecha_original = year+'-'+month+'-'+day;

            fecha = day+'/'+month+'/'+year; 
           
           
            $('#paciente_update').val(nombreApellido);
            $('#fecha_cita_update').val(fecha);
            $('#hora_cita_update').val(hora);
            $('#modal_evento').modal('show');
        },
        
        eventDrop:function(info, start, end){
          fecha_inicial = info.view
      
          let url = "<?php echo APP_URL;?>/controllers/reservas/modificar_reserva.php";
         
          fecha = info.event.start;
          let year = fecha.getFullYear();
          let month = fecha.getMonth();
          month = month+1;
          let day = fecha.getDate();
          
         // fecha_inicial = info.dateStr;
          
          fecha_original = year+'-'+month+'-'+day;

          var cadena = info.event.title;
            var arrayCadena = cadena.split("-");
            for (let i = 0; i < 1; i++) {
              nombre = arrayCadena[1]
              apellido = arrayCadena[2]
              hora = arrayCadena[0]
              fecha = arrayCadena[3]
               nombreApellido = nombre + '-' + apellido
            }
          
          titulo_evento = info.event.title;
          $('#fecha_evento').val(day+'-' + month + '-' +year);
          $('#hora_evento').val(hora);
          $('#nombre_paciente').val(nombreApellido);
          $('#nombre').val(nombre);
          $('#apellido').val(apellido);
          $('#titulo_evento').val(titulo_evento);
          $('#fecha_sin_formato').val(fecha_original);
          
          $('#modal_modificar_reserva').modal('show');

          
            }
      
      });
      
      calendar.render();

            
    });
   
   

//});
function recuperar_datos_form(info){
  fecha = info.event.start;
  let year = fecha.getFullYear();
  let month = fecha.getMonth();
  month = month+1;
  let day = fecha.getDate();
  
  fecha_original = year+'-'+month+'-'+day;

  var cadena = info.event.title;
  var arrayCadena = cadena.split("-");
  for (let i = 0; i < 1; i++) {
    nombre = arrayCadena[1]
    apellido = arrayCadena[2]
    hora = arrayCadena[0]
    var nombreApellido = nombre + '-' + apellido
  }
  let registro = {
   //fecha_cita : $('#fecha_cita_update').val(),
   
   fecha_cita : fecha_original,
   hora_cita : hora,
   paciente : nombreApellido,
  
 }
 console.log(fecha_cita);
 console.log(hora_cita);
 console.log(id_paciente);
 return registro;
}
</script>

<?php

include_once('view/layout/parte2.php');
include_once('view/layout/mensajes.php');
?>



<!-- Modal -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal Reserva -->
<div class="modal fade" id="modal_reserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reserva de Cita para el <span id="dia_de_la_semana"></span></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="<?php echo APP_URL;?>/controllers/reservas/controller_reservas.php" method="POST">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label>Horario</label>
                    <input type="time" id="hora_cita" name="hora_cita" class="form-control" require >
                    
                </div>
                <div class="col-md-6">
                    <label>Paciente</label>
                <select name="id_paciente" id="id_paciente" class="form-control">
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
        <div class="row">
            <div class="col-md-6">
                <label>Fecha</label>
                <input type="date" id="fecha_cita" class="form-control" name="fecha_cita"  >
            </div>
           
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btn-guardar" >Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div> <!-- fin modal reserva -->

<!-- Modal Evento -->
<div class="modal fade" id="modal_evento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span id="dia_de_la_semana"></span></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                 <label>Paciente</label>
                 <input type="text" id="paciente_update" name="paciente" class="form-control" disabled>
                </div>   
                
                <div class="col-md-6">
                  <label>Horario</label>
                    <input type="text" id="hora_cita_update" name="hora_cita" class="form-control" disabled>
                </div>
               
                <div class="col-md-6">
                    <label>Fecha</label>
                   
                    <input type="text" id="fecha_cita_update" class="form-control" name="fecha_cita_update" disabled >
                </div>
            </div>
        <div class="row">
         
           
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btn-delete" >Borrar</button>
      </div>
      <div id="respuesta_delete"></div>
    </div>


   
    <script>

$('#btn-delete').click(function(){
var paciente = $('#paciente_update').val();

Swal.fire({
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Yes',
  title: '¿Está seguro de eliminar la reserva de '+ nombre + '-' + apellido  + '-' + fecha_original + '-' + hora +'hs',
  denyButtonText: 'No',
  customClass: {
    actions: 'my-actions',
    cancelButton: 'order-1 right-gap',
    confirmButton: 'order-2',
    denyButton: 'order-3',
  },
}).then((result) => {
  if (result.isConfirmed) {
    
    let url = "<?php echo APP_URL;?>/controllers/reservas/delete.php";
    $.ajax({
          type: 'GET',
          url: url,
          data: { fecha: fecha_original, hora: hora },
          success: function(response) {
            $('#respuesta_delete').html(response);
            Swal.fire('Reserva eliminada', '', 'success');
            $('#modal_evento').modal('hide'); // Hide the modal after success
          },
          error: function() {
            Swal.fire('Error', 'No se pudo eliminar la reserva', 'error');
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Los cambios no se guardaron', '', 'info');
      }
})
  
})

</script>
  </div>
</div> <!-- fin modal evento -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
 <!-- Modal Modificar reserva -->
 <div class="modal fade" id="modal_modificar_reserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="exampleModalLabel">Modificar horario </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="col-md-6">
            <label>Paciente</label>
            <input type="text" id="nombre_paciente" name="nombre_paciente" class="form-control" disabled>
            <input type="hidden" id="nombre" name="nombre" class="form-control" disabled>
            <input type="hidden" id="apellido" name="apellido" class="form-control" disabled>
            <input type="hidden" id="titulo_evento" name="titulo_evento" class="form-control" disabled>
            <input type="hidden" id="titulo_nuevo" name="titulo_nuevo" class="form-control" disabled>
            
          </div>
            
                <div class="col-md-6">
                  <label>Fecha</label>
                  <input type="text" id="fecha_evento" class="form-control" name="fecha_evento" disabled >  
                  <input type="hidden" id="fecha_sin_formato" class="form-control" name="fecha_sin_formato" disabled >  
                </div>
                <div class="col-md-6">
                  <label>Hora</label>
                <input type="time" id="hora_evento" class="form-control" name="hora_evento" required >
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btn_modificar_reserva" >Modificar</button>
      </div>
      <div id="respuesta_modificar"></div>
    </div>
  </div>

</html>
<script>
$('#btn_modificar_reserva').click(function(){
  if($('#hora_evento').val() == ""){
    alert("Ingrese la hora");
  }else{
    let url = "<?php echo APP_URL;?>/controllers/reservas/modificar_reserva.php";
    var fecha= $('#fecha_evento').val();
    var hora= $('#hora_evento').val();
    var nombre= $('#nombre').val();
    var apellido= $('#apellido').val();
    var title_anterior= $('#titulo_evento').val();
    var title_nuevo = hora +'-'+nombre+'-'+apellido+'-'+fecha;

    $.ajax({
          type: 'GET',
          url: url,
          data: { title_nuevo:title_nuevo,title_anterior:title_anterior, fecha:fecha_original, hora:hora },
          success: function(response) {
            $('#respuesta_modificar').html(response);
            Swal.fire('Reserva modificada', '', 'success');
            $('#modal_evento').modal('hide'); // Hide the modal after success
          },
          error: function() {
            Swal.fire('Error', 'No se pudo cambiar la reserva', 'error');
          }
        });
      }
    }) 
    
</script>