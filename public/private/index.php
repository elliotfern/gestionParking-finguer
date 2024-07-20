<?php
// Genera o obtén tu clave secreta
$loggedInUser = ($_SESSION['user']['id']);
?>

<div class="alert alert-success" role="alert">
    <h1><strong><span id="userDiv2"> </span></strong>!</h1>
</div>

<h2>Office Calendar</h2>

<!-- Button para abrir el modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
  Add Event
</button>

<hr>

<div id="calendar"></div>


<!-- Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventModalLabel">Add New Office Task</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>-->
        </button>
      </div>
      <div class="modal-body">
        <!-- Formulario para añadir evento -->
        <form id="addEventForm">
            <div class="row g-4">

                <div class="col-12">
                    <label for="eventType" class="bold">Task type:</label>
                    <select class="form-select" id="eventType" required>
                    <option value="" selected>Select an option:</option>
                    <option value="1">Cleaning</option>
                    <option value="2">Phone</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="eventStart" class="bold">Start Date & Time:</label>
                    <input type="datetime-local" class="form-control" id="eventStart" required>
                </div>

                <div class="col-6">
                    <label for="eventEnd" class="bold">End Date & Time:</label>
                    <input type="datetime-local" class="form-control" id="eventEnd" required>
                </div>

                <div class="col-12">
                    <label for="eventUser" class="bold">Assign to Employee:</label>
                    <select class="form-select" name="eventUser" id="eventUser" required>
                </select>

                </div>
                
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">Create Office Task</button>
                </div>

            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
    #calendar {
        height: 600px; /* Ajusta la altura según tus necesidades */
    }

    .event-blue {
        background-color: #1981CA!important;
        color: white; /* Color del texto */
    }

    .event-red {
        background-color: #CA2419 !important;
        color: white; /* Color del texto */
    }
</style>

<script>
    nameUser2('<?php echo $loggedInUser; ?>');

    function nameUser2(idUser) {
        let urlAjax = "https://" + window.location.hostname + "/api/users/get/?type=user&id=" + idUser;
        $.ajax({
            url: urlAjax,
            type: 'GET',
            beforeSend: function (xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');

                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function (data) {
                // Modifica el contenido de un div con el resultado de la API
                let responseData = JSON.parse(data); // Parsea la respuesta JSON
                let welcomeMessage = responseData.name ? `Welcome back, ${responseData.name}` : 'User not found';
                $('#userDiv2').html(welcomeMessage); // Muestra el mensaje en tu página

                // Alternativamente, guarda el ID de usuario en localStorage
                localStorage.setItem('user_id', responseData.id);
            },
            error: function (error) {
                console.error('Error: ' + JSON.stringify(error));
            }
        });
    }

async function fetchUsers() {
  const server = window.location.hostname;
  const apiUrl = `https://${server}/api/users/get/?type=users`; // Asegúrate de que la URL de la API sea correcta

  try {
    const response = await fetch(apiUrl, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}` // Si necesitas autenticación
      }
    });

    if (!response.ok) {
      throw new Error('Network response was not ok' + response.statusText);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

// Obtener una referencia al select
const selectLoggedBy = document.getElementById('eventUser');

// Llamar a la función fetchUsers para obtener la lista de usuarios
fetchUsers().then(users => {
    // Limpiar el select por si ya tenía opciones
    selectLoggedBy.innerHTML = '';

    // Agregar la opción por defecto
    const defaultOption = document.createElement('option');
    defaultOption.value = '0';
    defaultOption.textContent = 'Select an option:';
    selectLoggedBy.appendChild(defaultOption);

    // Iterar sobre los usuarios y agregarlos como opciones al select
    users.forEach(user => {
        const option = document.createElement('option');
        option.value = user.id;
        option.textContent = user.name.split(' ')[0]; ;
        selectLoggedBy.appendChild(option);
    });
});

 document.addEventListener('DOMContentLoaded', function () {
        let urlAjax = `https://${window.location.hostname}/api/calendar/all/`;
        let token = localStorage.getItem('token');

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek', // Vista semanal
            firstDay: 1, // Comienza desde el lunes (0 = domingo, 1 = lunes, ..., 6 = sábado)
            weekends: false, // Oculta los fines de semana
            slotMinTime: '09:00:00', // Hora mínima del día (9:00 AM)
            slotMaxTime: '17:45:00', // Hora máxima del día (6:00 PM)
            dayHeaderContent: function(arg) {
                // Personaliza el contenido del encabezado del día
                let dayOfWeek = arg.date.toLocaleString('default', { weekday: 'short' }); // Abreviatura del día de la semana
                let dayOfMonth = arg.date.getDate(); // Día del mes
                let month = arg.date.getMonth() + 1; 
                return `${dayOfWeek} ${dayOfMonth}/${month}`;
             },
             dateClick: function(info) {
                // Abrir el modal al hacer clic en una fecha
                var modal = new bootstrap.Modal(document.getElementById('addEventModal'));
                modal.show();

                // Poner la fecha seleccionada en el campo de "Start Date & Time"
                // Formatear la fecha seleccionada al formato esperado por el campo datetime-local
                let dateStr = info.dateStr.split('+')[0];
                document.getElementById('eventStart').value = dateStr;
                
                // Añadir una hora a la fecha seleccionada para el campo "End Date & Time"
                let startDate = new Date(info.dateStr);
                startDate.setHours(startDate.getHours() + 2);
                let endDateStr = startDate.toISOString().substring(0, 16);
                document.getElementById('eventEnd').value = endDateStr;

            },
            events: function (fetchInfo, successCallback, failureCallback) {
            fetch(urlAjax, {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => response.json())
            .then(data => {
                // Mapear los eventos para agregar el nombre del usuario como título extendido
                let events = data.map(event => ({
                    id: event.id,
                    title: event.title,
                    start: event.start,
                    end: event.end,
                    user: event.user,
                    type: event.type,
                    extendedProps: {
                        user_name: event.name // Agregar el nombre del usuario
                    }
                }));
                successCallback(events);
            })
            .catch(error => failureCallback(error));
        },
        editable: true,
        selectable: true,

        eventClick: function (info) {
            if (confirm('Are you sure you want to delete this event?')) {
                fetch(urlAjax + '?id=' + info.event.id, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                }).then(() => info.event.remove());
            }
        },
        eventDrop: function (info) {
            var eventData = {
                id: info.event.id,
                start: info.event.startStr,
                end: info.event.endStr,
                user: info.event.extendedProps.user
            };
            fetch(urlAjax, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(eventData)
            });
        },
        eventContent: function(arg) {
            // Convertir el tipo de evento a entero usando parseInt
            let eventType = parseInt(arg.event.extendedProps.type);

            // Determinar la clase CSS en función del tipo de evento
            let eventClass = eventType === 1 ? 'event-blue' : 'event-red';

            // Construir el contenido HTML del evento con la clase determinada
            let user_name = arg.event.extendedProps.user_name;
            return {
                html: `<div class="fc-event-main ${eventClass}">${arg.timeText} - ${arg.event.title} (${user_name})</div>`
            };
        },
        eventDidMount: function(info) {
            // Acceder al elemento DOM del evento y aplicar estilos
            let eventType = parseInt(info.event.extendedProps.type);
            let eventElement = info.el.querySelector('.fc-event-main');
            if (eventType === 1) {
                eventElement.style.backgroundColor = 'blue';
            } else if (eventType === 2) {
                eventElement.style.backgroundColor = 'red';
            }
        }
    });

    calendar.render();

    // Manejar el envío del formulario para añadir evento
    document.getElementById('addEventForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Obtener los valores del formulario
        var start = document.getElementById('eventStart').value;
        var end = document.getElementById('eventEnd').value;
        var user = document.getElementById('eventUser').value;
        var type = document.getElementById('eventType').value;

        // Construir el objeto de datos del evento
        var eventData = {
            start: start,
            end: end,
            user: parseInt(user, 10),
            type: parseInt(type, 10)
        };

        // Enviar la solicitud para añadir el evento
        fetch(urlAjax, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(eventData)
        })
        .then(response => response.json())
        .then(data => {
            // Recargar los eventos después de añadir el nuevo evento
            calendar.refetchEvents();

            // Cerrar el modal después de añadir el evento
            var modal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
        modal.hide();
        })
        .catch(error => console.error('Error adding event:', error));
    });
});

</script>