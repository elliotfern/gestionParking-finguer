<?php
// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1); // Caroline, Tina and Elliot
?>

<div class="container-fluid">
    <h1>New Job</h1>

    <div class="alert alert-success" id="creaOk" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>New job create OK!</strong></h4>
        <h6>New job create successfully.</h6>
    </div>

    <div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>Error</strong></h4>
        <h6>Some data is not correct.</h6>
    </div>

    <form action="" method="POST" id="newJob">
        <div class="row g-4 quadre">

            <div class="col-6">
                <label for="date" class="bold">Date:</label>
                <input type="date" name="date" id="date" class="form-control" value="" ß>
                <div class="invalid-feedback" id="date_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <script>
                // Obtener la fecha actual
                var today = new Date();

                // Obtener el año, mes y día
                var year = today.getFullYear();
                var month = (today.getMonth() + 1).toString().padStart(2, '0'); // Agregar un 0 delante si es necesario
                var day = today.getDate().toString().padStart(2, '0'); // Agregar un 0 delante si es necesario

                // Formatear la fecha en formato YYYY-MM-DD
                var formattedDate = year + '-' + month + '-' + day;

                // Establecer el valor predeterminado del campo de entrada de fecha
                document.getElementById('date').value = formattedDate;
            </script>


            <div class="col-6">
                <label for="logged_by" class="bold">Logged by:</label>
                <select class="form-select" name="logged_by" id="logged_by">
                </select>
                <div class="invalid-feedback" id="logged_by_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="int_ext" class="bold">Type:</label>
                <select class="form-select" name="int_ext" id="int_ext">
                    <option selected value="0">Select an option:</option>
                    <option value="2">Internal</option>
                    <option value="1">External</option>
                </select>
                <div class="invalid-feedback" id="int_ext_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <hr>

            <div class="col-6">
                <label for="project_name" class="bold">Project:</label>
                <input type="text" name="project_name" id="project_name" class="form-control">
                <div class="invalid-feedback" id="project_name_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="client" class="bold">Client:</label>

                <select class="js-example-responsive" style="width: 100%" name="client" id="client">
                    <option value="">Select an option</option> <!-- Option to add a new client -->
                    <option value="new">Add New Client</option> <!-- Option to add a new client -->
                </select>
                <div class="invalid-feedback" id="client_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <hr>

            <?php if (in_array($user_id, $allowedUserIds)) {
            echo '<div class="col-6">
                <label for="estimated_time" class="bold">Estimated time hrs:</label>
                <input type="text" name="estimated_time" id="estimated_time" class="form-control">
            </div> <hr>';
            }?>

            <div class="col-12">
                <label for="job_comment" class="bold">Job comment (optional):</label>
                <textarea class="form-control" name="job_comment" id="job_comment" rows="5"></textarea>
            </div>

            <div class="col-6">
                <label for="project_email" class="bold">Project email (optional):</label>
                <input type="text" name="project_email" id="project_email" class="form-control">
            </div>

            <div class="col-6">
                <label for="project_phone" class="bold">Project phone (optional):</label>
                <input type="text" name="project_phone" id="project_phone" class="form-control">
            </div>

            <hr>

            <div class="form-group">
                <label for="project_management" class="bold">Staff Assigned:</label><br>
                <div class="btn-group-toggle" data-toggle="buttons">
                    
                </div>
            </div>

            <input type="hidden" id="userId" name="userId" value="<?php echo $user_id;?>">
            <input type="hidden" id="job_number" name="job_number" value="">

            <div class="col-3">
                <button type="submit" class="btn btn-primary" id="newJobBtn">Create new Job</button>
            </div>

    </form>

</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNewClient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="alert alert-success" id="creaOk2" style="display:none" role="alert">
                    <h4 class="alert-heading"><strong>New client create OK!</strong></h4>
                    <h6>New client create successfully.</h6>
                </div>

                <div class="alert alert-danger" id="creaErr2" style="display:none" role="alert">
                    <h4 class="alert-heading"><strong>Error</strong></h4>
                    <h6>Some data is not correct.</h6>
                </div>
                <!-- Form to add a new client (hidden by default) -->
                <form action="" method="POST" id="newClient">
                    <div class="row g-4">
                        <div class="col-6">
                            <label for="client_name" class="bold">Client Name:</label>
                            <input type="text" name="client_name" id="client_name" class="form-control">
                            <div class="invalid-feedback" id="client_name_error" style="display:block!important">
                                * Required
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="business_name" class="bold">Business Name:</label>
                            <input type="name" name="business_name" id="business_name" class="form-control">
                            <div class="invalid-feedback" id="business_name_error" style="display:block!important">
                                * Required
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="email" class="bold">E-mail:</label>
                            <input type="text" name="email" id="email" class="form-control">
                            <div class="invalid-feedback" id="email_error" style="display:block!important">
                                * Required
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="phone" class="bold">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                            <div class="invalid-feedback" id="phone_error" style="display:block!important">
                                * Required
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="newClientBtn">Create new Client</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<style>
    /* Adjust the height of the select box */
    .select2-container--default .select2-selection--single {
        height: 38px;
        /* Adjust this value as needed */
    }

    /* Adjust the line-height to vertically center the text */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
        /* Match this value to the height */
    }

    /* Adjust the dropdown height */
    .select2-dropdown {
        max-height: 400px;
        /* Adjust this value as needed */
    }

    /* Allow the dropdown to scroll */
    .select2-results__options {
        max-height: 400px;
        /* Adjust this value as needed */
        overflow-y: auto;
    }

    /* Hide the add new client form initially */
    #add-client-form {
        display: none;
    }

</style>

<script>

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
const selectLoggedBy = document.getElementById('logged_by');

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

// Función para generar dinámicamente el fragmento HTML
async function generateUserCheckboxes() {
  const users = await fetchUsers();
  const container = document.querySelector('.btn-group-toggle');

  // Limpiar el contenedor por si ya tenía opciones
  container.innerHTML = '';

  // Iterar sobre los usuarios y agregarlos como etiquetas de checkbox al contenedor
  users.forEach((user, index) => {
    const label = document.createElement('label');
    label.classList.add('btn', 'btn-secondary');

    const input = document.createElement('input');
    input.type = 'checkbox';
    input.name = 'project_management[]';
    input.value = user.id;
    
    const textNode = document.createTextNode(' ' + user.name.split(' ')[0]);

    label.appendChild(input);
    label.appendChild(textNode);

    // Agregar un espacio entre las etiquetas
    if (index !== 0) {
      container.appendChild(document.createTextNode(' '));
    }

    container.appendChild(label);
  });
}

// Llamar a la función para generar dinámicamente el fragmento HTML
generateUserCheckboxes();

    // AJAX EVENT
    // Escuchar el evento submit del formulario
    $("#newJobBtn").click(function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada

        // Realizar la solicitud AJAX para obtener el número de job
        $.ajax({
            url: "https://" + window.location.hostname + "/api/job/get/?type=jobNumber",
            method: "GET",
            dataType: "json",
            beforeSend: function(xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');

                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function(numeroJob) {
                // Asignar el número de job al campo oculto
                $('#job_number').val(numeroJob);

                // Enviar el formulario
                $.ajax({
                    url: "https://" + window.location.hostname + "/api/job/post/?type=job",
                    method: 'POST',
                    dataType: "json",
                    beforeSend: function(xhr) {
                        // Obtener el token del localStorage
                        let token = localStorage.getItem('token');

                        // Incluir el token en el encabezado de autorización
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    },
                    data: $("#newJob").serialize(), // Serializar el formulario
                    success: function(response) {
                        $("#creaOk").show();
                        $("#creaErr").hide();

                        // Limpiar los campos del formulario
                        $("#newJob")[0].reset();

                        // Limpiar los mensajes de error
                        $(".invalid-feedback").hide();

                        // Eliminar el color rojo de los campos de texto
                        $("input[type='text'], select").css("border-color", "");
                    },
                    error: function(response) {
                        console.log("error en el formulario de job")
                        // Recorres el objeto de errores y muestras cada mensaje de error
                        $.each(response.errors, function(key, value) {
                            // Aquí puedes mostrar los mensajes de error en el lugar adecuado en tu página web
                            $("#" + key + "_error").html('<strong>* ' + value + '</strong>').show();
                            $("#" + key).css("border-color", "red");
                        });


                        // RESTAR NUMERO

                        $.ajax({
                            url: "https://" + window.location.hostname + "/api/job/get/?type=jobNumberMinus",
                            method: 'PUT',
                            dataType: "json",
                            beforeSend: function(xhr) {
                                // Obtener el token del localStorage
                                let token = localStorage.getItem('token');

                                // Incluir el token en el encabezado de autorización
                                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                            },
                            success: function(revertResponse) {
                                // Manejar la reversión exitosa
                                // Puedes mostrar un mensaje de error específico para la primera operación
                            },
                            error: function(revertError) {
                                // Manejar errores durante la reversión de la primera operación
                            }
                        });
                    }
                });
            },
            error: function(error) {
                // Manejar errores
            }
        });
    });
</script>