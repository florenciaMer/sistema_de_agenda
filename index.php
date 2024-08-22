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
   
 
    <script src="fullcalendar-6.1.15/dist/index.global.min.js">
     
    </script>
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
var cadena = "";
var calendarEl;
var calendar;
var evento;
var realizada;
document.addEventListener('DOMContentLoaded', function(events) {

   calendarEl = document.getElementById('calendar');
   calendar = new FullCalendar.Calendar(calendarEl, {
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
      let data = {   
                titulo: info.event.title
            };

            let url = "<?php echo APP_URL;?>/controllers/reservas/cargar_reserva_title.php";
            $.ajax({
                type: 'GET',
                url: url,
                data: { titulo: data.titulo },
                success: function(response) {
                    var realizada = response.trim();
                    var footer = document.getElementById("modal-footer");
                    var btn, btn2;
         
        var existingBtn1 = document.getElementById("btn_deshacer_confirmar");
        if (existingBtn1) {
            footer.removeChild(existingBtn1);
        }

        var existingBtn2 = document.getElementById("btn-realizada");
        if (existingBtn2) {
            footer.removeChild(existingBtn2);
        }
                    if (footer) {
                        if (realizada == '1') {
                            btn = document.createElement("button");
                            btn.type = "button";
                            btn.className = "btn btn-secondary";
                            btn.id = "btn_deshacer_confirmar";
                            btn.innerHTML = "Deshacer cita realizada";
                            footer.appendChild(btn);
                        } else if (realizada == '0') {
                            if (btn) {
                                footer.removeChild(btn);
                            }
                            btn2 = document.createElement("button");
                            btn2.type = "button";
                            btn2.className = "btn btn-success";
                            btn2.id = "btn-realizada";
                            btn2.innerHTML = "Confirmar cita realizada <i class='bi bi-check-circle'></i>";
                            footer.appendChild(btn2);
                        }
                    } else {
                        console.log("No se encontró ningún elemento con el id 'modal-footer'");
                    }
                },
                error: function() {
                    Swal.fire('Error', 'No se encontró la realización en la base de datos', 'error');
                }
            });
  
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

            fecha = year+'-'+month+'-'+day; 
           
           
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

   cadena = info.event.title;
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
                        <?php echo $paciente['nombre'].'-'. $paciente['apellido']?>
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
      <div class="modal-footer" id="modal-footer">
      <script>
      

    
      </script>
      
           
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btn-delete" >Borrar</button>
      </div>
      <div id="respuesta_delete"></div>
      <div id="respuesta_realizada"></div>
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

    // Convertir la cadena a un objeto Date
    let dateParts = fecha.split("-"); // Separa la cadena en partes [yyyy, mm, dd]
    let year = parseInt(dateParts[0], 10);
    let month = parseInt(dateParts[1], 10) - 1; // Los meses en JavaScript van de 0 a 11
    let day = parseInt(dateParts[2], 10);

    let fechaDate = new Date(year, month, day);

    // Formatear la fecha como día-mes-año
    let fecha_formateada = day + '-' + (month + 1) + '-' + year;
    alert(fecha_formateada)
    let hora = $('#hora_evento').val();
    let nombre = $('#nombre').val();
    let apellido = $('#apellido').val();
    let title_anterior = $('#titulo_evento').val();
    
    let title_nuevo = hora + '-' + nombre + '-' + apellido + '-' + fecha_formateada;


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
<script>
  $(document).on('click', '#btn-realizada', function() {
//$('#btn-realizada').click(function() {


  var modal_evento = document.getElementById("modal_evento");
    var footer = document.getElementById("modal-footer"); // Asegúrate de que el ID sea correcto

    if (modal_evento) {
        // Elimina los botones existentes antes de agregar nuevos
        var existingBtn1 = document.getElementById("btn_deshacer_confirmar");
        if (existingBtn1) {
            footer.removeChild(existingBtn1);
        }

        var existingBtn2 = document.getElementById("btn-realizada");
        if (existingBtn2) {
            footer.removeChild(existingBtn2);
        }

        // Crea y agrega el nuevo botón basado en el valor de 'realizada'
        if (realizada == '1') {
            console.log('realizada valor 1');
            var btn = document.createElement("button");
            btn.type = "button";
            btn.className = "btn btn-secondary";
            btn.id = "btn_deshacer_confirmar";
            btn.innerHTML = "Deshacer cita realizada";
            footer.appendChild(btn);
        } else if (realizada == '0') {
            var btn2 = document.createElement("button");
            btn2.type = "button";
            btn2.className = "btn btn-success";
            btn2.id = "btn-realizada";
            btn2.innerHTML = "Confirmar cita realizada <i class='bi bi-check-circle'></i>";
            footer.appendChild(btn2);
        }
      }
    var hora_cita = $('#hora_cita_update').val();
    var fecha_cita = $('#fecha_cita_update').val();
    var cadena = $('#paciente_update').val();

    var arrayCadena = cadena.split("-");
    let nombre = arrayCadena[0].trim();
    let apellido = arrayCadena[1].trim();

    if (fecha_cita && hora_cita && nombre && apellido) {

      var partesFecha = fecha_cita.split('/');
        var dia = partesFecha[0].padStart(2, '0');
        var mes = partesFecha[1].padStart(2, '0');
        var año = partesFecha[2];
        var fecha = `${año}-${mes}-${dia}`

       // var fecha = fecha_cita.split('/').reverse().join('-');
        let eventos = calendar.getEvents();
        let eventoEncontrado = null;

        for (let evento of eventos) {
            //let eventoFecha = evento.start.toISOString().split('T')[0]; // Fecha en formato YYYY-MM-DD
            //let eventoHora = evento.start.toTimeString().split(':')[0].substring(0, 5); // Hora en formato HH:MM
            let titulo = hora+'-'+nombre+ '-'+ apellido+'-'+fecha;
            console.log('fecha chat gpt')

            console.log('Evento en calendario:', evento.title);
            console.log('Título esperado:', titulo);

            if (evento.title == titulo) {
                  
                eventoEncontrado = evento;
                console.log("ENCONTRADO por confirmar !!!!!!*****")
                break;
            }
        }

        if (eventoEncontrado) {
            eventoEncontrado.setProp('backgroundColor', '#67de1f');
            eventoEncontrado.setProp('borderColor', '#67de1f');
            calendar.render(); // Refrescar los eventos para aplicar los cambios
           
          
            let url = "<?php echo APP_URL;?>/controllers/reservas/guardar_color.php";;  // Reemplaza con la ruta correcta
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    titulo: eventoEncontrado.title,  // Asegúrate de que el evento tenga un ID único
                    backgroundColor: '#67de1f',
                    borderColor: '#67de1f'
                },
                success: function(response) {
                    console.log('Color actualizado en la base de datos.');
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el color en la base de datos:', error);
                }
            });
            calendar.render(); // Refrescar los eventos para aplicar los cambios

        } else {
            console.log('No se encontró el evento en la fecha y hora especificada.');
        }
    }
    $(document).ready(function() {
  // Tu código para agregar el botón al modal aquí
  
  
});
   let url = "<?php echo APP_URL;?>/controllers/reservas/realizadas.php";
    $.ajax({
        type: 'GET',
        url: url,
        data: { fecha_cita: fecha_original, hora_cita: hora_cita, nombre: nombre, apellido: apellido },
        success: function(response) {
            $('#respuesta_realizada').html(response);
        },
    });
  } )


</script>
<script>
$(document).on('click', '#btn_deshacer_confirmar', function() {
//$('#btn_deshacer_confirmar').click(function(){
var cadena = $('#paciente_update').val();
var hora_cita = $('#hora_cita_update').val();
var fecha_cita = $('#fecha_cita_update').val();

//convierto la fecha primero el año
if (fecha_cita) {
    // Si la fecha es del formato YYYY-MM-DD o similar
    let fecha = new Date(fecha_cita);
    
    if (!isNaN(fecha)) {
        let year = fecha.getFullYear();
        let month = fecha.getMonth() + 1;
        let day = fecha.getDate();

        // Asegurar formato de dos dígitos para el mes y día
        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;

        let fecha_original = year + '-' + month + '-' + day;
        console.log(fecha_original);
    }
  }

var arrayCadena = cadena.split("-");

var hora_cita = $('#hora_cita_update').val();
    var fecha_cita = $('#fecha_cita_update').val();
    var cadena = $('#paciente_update').val();

    var arrayCadena = cadena.split("-");
    let nombre = arrayCadena[0].trim();
    let apellido = arrayCadena[1].trim();

    if (fecha_cita && hora_cita && nombre && apellido) {

      var partesFecha = fecha_cita.split('/');
        var dia = partesFecha[0].padStart(2, '0');
        var mes = partesFecha[1].padStart(2, '0');
        var año = partesFecha[2];
        var fecha = `${año}-${mes}-${dia}`

       // var fecha = fecha_cita.split('/').reverse().join('-');
        let eventos = calendar.getEvents();
        let eventoEncontrado = null;

        for (let evento of eventos) {
            //let eventoFecha = evento.start.toISOString().split('T')[0]; // Fecha en formato YYYY-MM-DD
            //let eventoHora = evento.start.toTimeString().split(':')[0].substring(0, 5); // Hora en formato HH:MM
            let titulo = hora+'-'+nombre+ '-'+ apellido+'-'+fecha;
            

            console.log('Evento en calendario:', evento.title);
            console.log('Título esperado:', titulo);

            if (evento.title == titulo) {
                  
                eventoEncontrado = evento;
                console.log("ENCONTRADO deshacer confirmar!!!!!*****")
                break;
            }
        }

        if (eventoEncontrado) {
            eventoEncontrado.setProp('backgroundColor', '#67de1f');
            eventoEncontrado.setProp('borderColor', '#67de1f');
            calendar.render(); // Refrescar los eventos para aplicar los cambios
           
            let url = "<?php echo APP_URL;?>/controllers/reservas/guardar_color.php";;  // Reemplaza con la ruta correcta
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    titulo: eventoEncontrado.title,  // Asegúrate de que el evento tenga un ID único
                    backgroundColor: '#3788d8',
                    borderColor: '#3788d8'
                },
                success: function(response) {
                    console.log('Color actualizado en la base de datos.');
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el color en la base de datos:', error);
                }
            });
           
            calendar.render(); // Refrescar los eventos para aplicar los cambios

        } else {
            console.log('No se encontró el evento en la fecha y hora especificada.');
        }
        /********************************************************** */
      // Obtenemos el precio para cada cita



      let url = "<?php echo APP_URL;?>/controllers/reservas/deshacer_confirmar.php";
      $.ajax({
            type: 'GET',
            url: url,
            data: { fecha_cita: fecha_original, hora_cita: hora_cita, nombre:nombre, apellido:apellido },
            success: function(response) {
              $('#respuesta_realizada').html(response);
            
          },
          
        });
      }
      })
     
</script>