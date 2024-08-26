<?php include_once('controllers/config.php');
include_once('view/layout/parte1.php');
include_once('controllers/pacientes/listado_de_pacientes.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas</title>
    <script src="fullcalendar-6.1.15/dist/index.global.min.js"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.js"></script>
</head>
<body>
    <div class="container" id="container-principal">
        <div class="row" style="margin-left: 3%;">
            <div class="col"></div>
            <div class="col-md-12 m-2">
                <h1 style="display: flex; justify-content: center;">Reserva de Citas</h1>
                <div id="calendar-container">
                    <div id='calendar' class="w-100"></div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>
<style>
    #container-principal{
        margin-left: 15%;
    }
    #calendar-container {
    
    display: flex;
    justify-content: flex-end; /* Alinea el contenido a la derecha */
    padding: 10px; /* Opcional: Añadir espacio alrededor del contenedor */
    margin-right: 30px; /* Añadir margen a la derecha para desplazar el calendario más a la derecha */
}

#calendar {
    width: 80%; /* Ajusta el ancho del calendario según sea necesario */
    max-width: 1200px; /* Opcional: Limita el ancho máximo del calendario */
    margin: 0 auto;
    height: calc(100vh - 100px); /* Ajusta la altura según necesites */
}
</style>
<script>
  let eventos;
  var realizada = 0;
  let calendar;
  let title_anterior_registro; 
  FullCalendar.globalLocales.push(function () {
    'use strict';
     var es = {
         code: "es",
         week: {
             dow: 1,
             doy: 4
         },
         buttonText: {
             prev: "Ant",
             next: "Sig",
             today: "Hoy",
             month: "Mes",
             week: "Semana",
             day: "Día",
             list: "Agenda"
         },
         weekText: "Sm",
         allDayText: "Todo el día",
         moreLinkText: "más",
         noEventsText: "No hay eventos para mostrar"
     };
     return es;
 }());
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
     calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        allDaySlot: false,
        height: 'auto',               // Ajusta automáticamente a la altura del contenedor
        contentHeight: 'auto',        // Opcional: Ajusta la altura del contenido
        expandRows: true,             // Expande filas para que todo el mes sea visible sin scroll
        headerToolbar: {
            left: 'prev,next today',  // Agrega botones de navegación en la izquierda
            center: 'title',          // Coloca el título en el centro
            right: 'dayGridMonth'
            
        },
        locale: 'es',
        lang: 'es',
        events: 'controllers/reservas/cargar_reserva.php',
        dateClick: function(info) {
            var fechaSeleccionada = info.dateStr;
            var diaDeLaSemana = new Date(fechaSeleccionada).getDay();
            var dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            $('#modal_reserva').modal("show");
            $('#dia_de_la_semana').html(dias[diaDeLaSemana] + " " + fechaSeleccionada);
            $('#fecha_cita').val(fechaSeleccionada);
        },
        eventClick: function(info) {
    var titulo = info.event.title;
    var url = "<?php echo APP_URL;?>/controllers/reservas/cargar_reserva_title.php";

    $.ajax({
        type: 'GET',
        url: url,
        data: { titulo: titulo },
        success: function(response) {
            var realizada = response.trim();
            var footer = document.getElementById("modal_footer_realizada");

            // Asegúrate de que el footer esté correctamente asignado
            console.log("footer:", footer);

            if (footer) {
                // Depura los botones existentes
                var existingBtn1 = document.getElementById("btn_deshacer_confirmar");
                var existingBtn2 = document.getElementById("btn-realizada");
                
                console.log("Existing Button 1:", existingBtn1);
                console.log("Existing Button 2:", existingBtn2);

                // Eliminar botones existentes si están presentes
                if (existingBtn1 && footer.contains(existingBtn1)) {
                    footer.removeChild(existingBtn1);
                }
                if (existingBtn2 && footer.contains(existingBtn2)) {
                    footer.removeChild(existingBtn2);
                }

                // Agregar botones según el estado 'realizada'
                if (realizada === '1') {
                    var btn = document.createElement("button");
                    btn.type = "button";
                    btn.className = "btn btn-secondary";
                    btn.id = "btn_deshacer_confirmar";
                    btn.innerHTML = "Deshacer cita realizada";
                    footer.appendChild(btn);
                } else if (realizada === '0') {
                    var btn2 = document.createElement("button");
                    btn2.type = "button";
                    btn2.className = "btn btn-success";
                    btn2.id = "btn-realizada";
                    btn2.innerHTML = "Confirmar cita realizada <i class='bi bi-check-circle'></i>";
                    footer.appendChild(btn2);
                }
            } else {
                console.error("No se encontró el elemento con el ID 'modal_footer_realizada'.");
            }

            // Procesar la información de la cita
            var arrayCadena = titulo.split("-");
            if (arrayCadena.length >= 4) {
                var hora = arrayCadena[0];
                var nombre = arrayCadena[1];
                var apellido = arrayCadena[2];

                var fecha = info.event.start;
                let year = fecha.getFullYear();
                let month = fecha.getMonth() + 1;
                let day = fecha.getDate();
                fecha = `${day.toString().padStart(2, '0')}-${month.toString().padStart(2, '0')}-${year}`;

                console.log(fecha)
                var nombreApellido = nombre + '-' + apellido;

                $('#paciente_update').val(nombreApellido);
                $('#fecha_cita_update').val(fecha);
                $('#hora_cita_update').val(hora);

                // Mostrar el modal después de actualizar el contenido
                title_anterior_registro = info.event.title;
                $('#modal_evento').modal('show');
            }
        },
        error: function() {
            Swal.fire('Error', 'No se encontró la realización en la base de datos', 'error');
        }
    });
},


        eventDrop: function(info) {
            var fecha = info.event.start;
            let year = fecha.getFullYear();
            let month = fecha.getMonth() + 1;
            let day = fecha.getDate();
            var fechaOriginal = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

            var arrayCadena = info.event.title.split("-");
            if (arrayCadena.length >= 4) {
                var hora = arrayCadena[0];
                var nombre = arrayCadena[1];
                var apellido = arrayCadena[2];
                var fechaEvento = arrayCadena[3];
                var nombreApellido = nombre + ' ' + apellido;

                $('#fecha_evento').val(`${day.toString().padStart(2, '0')}-${month.toString().padStart(2, '0')}-${year}`);
                $('#hora_evento').val(hora);
                $('#nombre_paciente').val(nombreApellido);
                $('#nombre').val(nombre);
                $('#apellido').val(apellido);
                $('#titulo_evento').val(info.event.title);
                $('#fecha_sin_formato').val(fechaOriginal);

                $('#modal_modificar_reserva').modal('show');
            }
        },
    
    eventsSet: function(events) {
            // Aquí obtienes los eventos después de que se hayan cargado
            console.log('Eventos cargados:', events);
            let hora = '12:00'; // ejemplo
            let nombre = 'Juan'; // ejemplo
            let apellido = 'Pérez'; // ejemplo
            let fecha = '2024-08-22'; // ejemplo

            let titulo = hora + '-' + nombre + '-' + apellido + '-' + fecha;
            let eventoEncontrado = null;

            for (let evento of events) {
                if (evento.title === titulo) {
                    eventoEncontrado = evento;
                    console.log("ENCONTRADO por confirmar !!!!!!*****");
                    break;
                }
            }
        }
    });
    calendar.render();
    calendar.setOption('locale', 'es');
  
});
function actualizarColorEvento(hora, nombre, apellido, fecha, color) {
        let eventos = calendar.getEvents();
        let eventoEncontrado = null;
        console.log('eventos', eventos);
        let titulo = hora + '-' + nombre + '-' + apellido + '-' + fecha;

        for (let evento of eventos) {
            console.log('Evento en calendario:', evento.title);
            console.log('Título esperado:', titulo);

            if (evento.title === titulo) {
                eventoEncontrado = evento;
                console.log("ENCONTRADO por confirmar !!!!!!*****");
                break;
            }
        }

        if (eventoEncontrado) {
            eventoEncontrado.setProp('backgroundColor', color);
            eventoEncontrado.setProp('borderColor', color);

            let url = "<?php echo APP_URL;?>/controllers/reservas/guardar_color.php";
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    titulo: eventoEncontrado.title,
                    backgroundColor: color,
                    borderColor: color
                },
                success: function(response) {
                    console.log('Color actualizado en la base de datos.');
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el color en la base de datos:', error);
                }
            });
        } else {
            console.log('No se encontró el evento en la fecha y hora especificada.');
        }
    }

</script>

<?php
include_once('view/layout/parte2_agenda.php');
include_once('view/layout/mensajes.php');
?>

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
                            <input type="time" id="hora_cita" name="hora_cita" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Paciente</label>
                            <select name="id_paciente" id="id_paciente" class="form-control">
                                <?php foreach ($pacientes_datos as $paciente) { ?>
                                    <option value="<?php echo $paciente['id_paciente'];?>">
                                        <?php echo $paciente['nombre'].'-'. $paciente['apellido'];?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha</label>
                            <input type="date" id="fecha_cita" class="form-control" name="fecha_cita">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- fin modal reserva -->

<!-- Modal Evento -->
<div class="modal fade" id="modal_evento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span id="dia_de_la_semana">Reserva:</span></h5>
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
                        <input type="text" id="hora_cita_update" name="hora_cita" class="form-control" >
                    </div>
                    <div class="col-md-6">
                        <label>Fecha</label>
                        <input type="text" id="fecha_cita_update" class="form-control" name="fecha_cita_update" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer " id="modal_footer_realizada">
                
                <button type="button" class="btn btn-info" id="btn-modificar-hora" >Modificar</button>
                <button type="submit" class="btn btn-primary" id="btn-delete" >Borrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <div id="respuesta_delete"></div>
        <div id="respuesta_modificar_hora"></div>
      </div>
    </div>
    <script>

$('#btn-delete').click(function() {
    var fecha_formateada_borrar = ''; // Inicializa la variable con un valor vacío
    var paciente = $('#paciente_update').val();
    var arrayCadena = paciente.split("-");

    // Verificar que la cadena tiene al menos dos partes
    if (arrayCadena.length >= 2) {
        var nombre = arrayCadena[0].trim();
        var apellido = arrayCadena[1].trim();
    }

    var hora_cita = $('#hora_cita_update').val();
    var fecha_cita = $('#fecha_cita_update').val();

    // Verificar que la fecha tiene un valor y el formato esperado
    if (fecha_cita) {
        var partes = fecha_cita.split('-'); // Asumiendo que la fecha viene en formato "dd-mm-yyyy"
        console.log("Partes de la fecha: ", partes);

        if (partes.length === 3) {
            var dia = partes[0];
            var mes = partes[1];
            var año = partes[2];

            fecha_formateada_borrar = año + '-' + mes + '-' + dia;
            console.log("Fecha reformateada: " + fecha_formateada_borrar);
        } else {
            console.log("Error: La fecha no está en el formato esperado.");
        }
    } else {
        console.log("Error: No se pudo obtener el valor de #fecha_cita_update.");
    }

    console.log('Fecha formateada para borrar:', fecha_formateada_borrar);

console.log(hora_cita)

Swal.fire({
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Yes',
  title: '¿Está seguro de eliminar la reserva de '+ nombre + '-' + apellido  + '-' + fecha_cita + '-' + hora_cita +'hs',
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
          data: { fecha: fecha_formateada_borrar, hora: hora_cita },
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

        </div>
    </div>
</div> <!-- fin modal evento -->

<!-- Modal Modificar Reserva -->
<div class="modal fade" id="modal_modificar_reserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Reserva</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_modificar_reserva">
                    <input type="hidden" id="titulo_evento" name="titulo_evento">
                    <input type="hidden" id="fecha_sin_formato" name="fecha_sin_formato">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha</label>
                            <input type="text" id="fecha_evento" class="form-control" name="fecha_evento" disabled>
                        </div>
                        <div class="col-md-6">
                            <label>Horario</label>
                            <input type="text" id="hora_evento" name="hora_evento" class="form-control" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_modificar_reserva">Guardar Cambios</button>
           <div id="respuesta_modificar_reserva"></div>
            </div>
        </div>
    </div>
</div> <!-- fin modal modificar reserva -->
<script>
$('#btn-modificar-hora').click(function() {
    
    if ($('#hora_cita_update').val() == "") {
        alert("Ingrese la hora");
    } else {
        var hora = $('#hora_cita_update').val();
        var fecha = $('#fecha_cita_update').val();
        var cadena = $('#paciente_update').val();
        var arrayCadena = cadena.split("-");

        var nombre = "";
        var apellido = "";

        if (arrayCadena.length >= 2) {
            nombre = arrayCadena[0].trim();
            apellido = arrayCadena[1].trim();
        }

        var fecha_formateada = "";

        if (fecha && fecha.length === 10) {
            var partesFecha = fecha.split('-');
            if (partesFecha.length === 3) {
                var dia = partesFecha[0].padStart(2, '0');
                var mes = partesFecha[1].padStart(2, '0');
                var año = partesFecha[2];
                fecha_formateada = `${año}-${mes}-${dia}`;
            }
        }

        let title_nuevo = hora + '-' + nombre + '-' + apellido + '-' + fecha_formateada;
        let url = "<?php echo APP_URL;?>/controllers/reservas/modificar_horario_reserva.php";

        $.get(url, {title_nuevo: title_nuevo, fecha:fecha_formateada, hora:hora,
            title_anterior: title_anterior_registro
        }, function(datos){
         $('#respuesta_modificar_hora').html(datos);
        });
        }
    });
    

  


   


    
</script>
<script>
  $('#btn_modificar_reserva').click(function(){
  if($('#hora_evento').val() == ""){
    alert("Ingrese la hora");
  }else{
  
// Obtener el valor de la fecha
var fecha = $('#hora_evento').val();
var fecha = $('#fecha_evento').val();
var fecha_formateada;
console.log('Fecha original:', fecha);

// Asegúrate de que la fecha esté en el formato correcto
if (fecha && fecha.length === 10) {
    // Dividir la fecha en partes
    let dateParts = fecha.split("-");
    console.log('Partes de la fecha:', dateParts);

    var partesFecha = fecha.split('-');
    
    console.log("Partes de la fecha:", partesFecha);

    if (partesFecha.length === 3) {
        var dia = (partesFecha[0] || '').padStart(2, '0');
        var mes = (partesFecha[1] || '').padStart(2, '0');
        var año = partesFecha[2];
         fecha_formateada = `${año}-${mes}-${dia}`;
        
        console.log("Fecha convertida************:", fecha); 
    } 
}

    // Formatear la fecha como día-mes-año
    let hora = $('#hora_evento').val()
    let nombre = $('#nombre').val();
    let apellido = $('#apellido').val();
    let title_anterior = $('#titulo_evento').val();
    
    let title_nuevo = hora + '-' + nombre + '-' + apellido + '-' + fecha_formateada;
    
    let url = "<?php echo APP_URL;?>/controllers/reservas/modificar_reserva.php";

    $.ajax({
          type: 'GET',
          url: url,
          data: { title_nuevo:title_nuevo,title_anterior:title_anterior, fecha:fecha_formateada, hora:hora },
          success: function(response) {
            $('#btn_modificar_reserva').html(response);
            calendar.refetchEvents(); // Actualiza los eventos del calendario   
           //Swal.fire('Reserva modificada', '', 'success');
            $('#modal_modificar_reserva').modal('hide'); // Hide the modal after success
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

  var modal_evento = document.getElementById("modal_evento");
  var footer = document.getElementById("modal_footer_realizada");
    if (modal_evento) {
        // Elimina los botones existentes antes de agregar nuevos
        var existingBtn1 = document.getElementById("btn_deshacer_confirmar");
        if (existingBtn1) {
            footer.removeChild(existingBtn1);
        }

        var existingBtn2 = document.getElementById("btn-realizada");
        console.log('btn2****')
        console.log(btn2)
        console.log("Footer HTML:", footer.innerHTML);
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

// Verificar que la cadena tiene al menos dos partes
if (arrayCadena.length >= 2) {
     nombre = arrayCadena[0].trim();
     apellido = arrayCadena[1].trim();
    // Ahora puedes usar las variables nombre y apellido sin problemas
    console.log('nombre')
    console.log(nombre)
} else {
    console.error("La cadena no tiene el formato esperado. Se esperaba un formato 'nombre-apellido' pero se recibió: " + cadena);
    // Puedes mostrar un mensaje al usuario o manejar el error de alguna otra manera
}

    if (fecha_cita && hora_cita && nombre && apellido) {

      console.log("Valor original de fecha_cita:", fecha_cita);

      //estoy aca ***********************
if (typeof fecha_cita === 'string' && fecha_cita.includes('-')) {
    var partesFecha = fecha_cita.split('-');
    
    console.log("Partes de la fecha:", partesFecha);

    if (partesFecha.length === 3) {
        var dia = (partesFecha[0] || '').padStart(2, '0');
        var mes = (partesFecha[1] || '').padStart(2, '0');
        var año = partesFecha[2];
        var fecha = `${año}-${mes}-${dia}`;
        
        console.log("Fecha convertida:", fecha); // Verifica que la conversión sea correcta
    } else {
        console.error("Fecha incompleta o mal formada: ", fecha_cita);
    }
} else {
    console.error("Fecha no válida o en formato incorrecto: ", fecha_cita);
}

        //var fecha = fecha_cita.split('/').reverse().join('-');
        console.log('nombre')
        console.log(nombre)
        actualizarColorEvento(hora_cita, nombre, apellido, fecha, '#67de1f')
        $('#modal_evento').modal('hide');
       
    }
    $(document).ready(function() {
  // Tu código para agregar el botón al modal aquí
  
  
});
   let url = "<?php echo APP_URL;?>/controllers/reservas/realizadas.php";
    $.ajax({
        type: 'GET',
        url: url,
        data: { fecha_cita: fecha, hora_cita: hora_cita, nombre: nombre, apellido: apellido },
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

    if (typeof fecha_cita === 'string' && fecha_cita.includes('-')) {
    var partesFecha = fecha_cita.split('-');
    
    console.log("Partes de la fecha:", partesFecha);

    if (partesFecha.length === 3) {
        var dia = (partesFecha[0] || '').padStart(2, '0');
        var mes = (partesFecha[1] || '').padStart(2, '0');
        var año = partesFecha[2];
        var fecha = `${año}-${mes}-${dia}`;
        
        console.log("Fecha convertida:", fecha); // Verifica que la conversión sea correcta
    } else {
        console.error("Fecha incompleta o mal formada: ", fecha_cita);
    }


       // var fecha = fecha_cita.split('/').reverse().join('-');
        
       actualizarColorEvento(hora_cita, nombre, apellido, fecha, '#3788d8')
       $('#modal_evento').modal('hide');
  
        /********************************************************** */
      // Obtenemos el precio para cada cita



      let url = "<?php echo APP_URL;?>/controllers/reservas/deshacer_confirmar.php";
      $.ajax({
            type: 'GET',
            url: url,
            data: { fecha_cita: fecha, hora_cita: hora_cita, nombre:nombre, apellido:apellido },
            success: function(response) {
              $('#respuesta_realizada').html(response);
            
          },
          
        });
      }
      })
    
</script>
</html>
