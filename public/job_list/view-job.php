<?php
$id = $params['id'];

// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1, 2, 4); // Caroline, Tina and Elliot
?>

<div class="container-fluid">
    <h1>Project information</h1>
    <h2 id="jobTitle"></h2>
    <h5 id="jobNumber"></h5>

    <div class="col-3" style="margin-top:20px;margin-bottom:20px">
        <?php
        if (in_array($user_id, $allowedUserIds)) {
            echo '<a class="btn btn-primary" href="' . APP_SERVER . '/job-list/update/' . $id . '" role="button">Update Job information</a>';
        }
        ?>
    </div>

    <div class="row g-4 quadre" style="margin-bottom:30px">

        <div id="statusContainer">
            <span class="bold">Current Status:</span>
            <span id="status"></span>
        </div>

        <div class="col-6">
            <span class="bold">Date:</span>
            <input type="date" name="date" id="date" class="form-control" readonly>
        </div>

        <div class="col-6">
            <span class="bold">Logged by:</span>
            <input type="text" name="logged_by" id="logged_by" class="form-control" readonly>
        </div>

        <div class="col-6">
            <span class="bold">Type:</span>
            <input type="text" name="int_ext" id="int_ext" class="form-control" readonly>
        </div>

        <hr>

        <div class="col-6">
            <span class="bold">Client:</span>
            <?php
            global $conn;
            $sql = "SELECT c.business_name, c.id
                FROM job_list AS j
                INNER JOIN client_list AS c ON j.client = c.id
                WHERE j.id = $id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            // Mostrar los nombres como opciones en el select
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<p><a href="' . APP_SERVER . '/client-list/view/' . $row['id'] . '">' . $row['business_name'] . '</a></p>';
            }
            ?>
            </select>
        </div>

        <div class="col-6">
            <span class="bold">Job comment:</span>
            <input type="text" name="job_comment" id="job_comment" class="form-control" readonly>
        </div>

        <div class="col-6">
            <span class="bold">Project email:</span>
            <input type="text" name="project_email" id="project_email" class="form-control" readonly>
        </div>

        <div class="col-6">
            <span class="bold">Project phone:</span>
            <input type="text" name="project_phone" id="project_phone" class="form-control" readonly>
        </div>

        <hr>

        <div id="jobHoursInfo" style="display:none; margin-top:20px;">
                <p><strong>Project Time Goal:</strong> <span id="hoursAvailable"></span> hours.</p>
                <p><strong>Assigned hours:</strong> <span id="hoursAssigned"></span>.</p>
                <p><strong>Available hours:</strong> <span id="availableHours"></span>.</p>
        </div>

        <hr>

        <div class="form-group">
            <span class="bold">Staff Assigned: </span><br>
            <div class="btn-group-toggle" data-toggle="buttons" id="assignedStaff" style="margin-top:25px"></div>
        </div>

    </div>
</div>

<div class="row g-4 quadre" style="margin-bottom:30px">
    <h5>History Status Changes</h5>

    <div id="historyJobContainer"></div>

    <div id="errorStatusMessage" style="margin-top:20px;margin-bottom:20px"></div>

</div>

<div class="row g-4 quadre" style="margin-bottom:30px">
    <h5>Client forms</h5>

    <div class="data-table-container" id="clientFormsJobs" style="display:none">
        <table id="formTable" class="table table-striped" id="clientFormsJobsTable">
            <thead class="table-primary">
                <tr>
                    <th>Category</th>
                    <th>Date</th>
                    <th>View Form</th>
                </tr>
            </thead>
            <tbody id="formTableBody">
            </tbody>
        </table>
    </div>

    <div id="errorFormMessage" style="margin-top:20px;margin-bottom:20px"></div>

</div>


<div class="row g-4 quadre" style="margin-bottom:30px">
    <h5>Job Notes</h5>

    <div class="col-3" style="margin-top:20px;margin-bottom:20px">
        <a class="btn btn-primary" href="<?php echo APP_SERVER; ?>/job-list/notes/new/<?php echo $id; ?>" role="button">Create new Note</a>
    </div>

    <div id="notesContainer"></div>

    <div id="errorNotesMessage" style="margin-top:20px;margin-bottom:20px"></div>

</div>

<div class="row g-4 quadre" style="margin-bottom:30px">
    <h5>Job Tasks</h5>

    <div class="col-3" style="margin-top:20px;margin-bottom:20px">
        <a class="btn btn-primary" href="<?php echo APP_SERVER; ?>/planning-list/new/job/<?php echo $id; ?>" role="button">Create new task</a>
    </div>

    <div class="table-responsive" style="margin-top:40px;margin-bottom:40px;display:none" id="clientTasks">
            <table class="table table-striped" id="clientTasksTable" style="display:none">
                <thead class="table-primary">
                    <tr>
                        <th>Task Name</th>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Time assign</th>
                        <th>Date of creation</th> 
                    </tr>
                </thead>
                <tbody id="tasksTableBody">

                </tbody>
            </table>
        </div>

        <div id="errorTaskMessage" style="margin-top:20px;margin-bottom:20px"></div>

</div>


</div>

</div>

<script>
    jobInfo('<?php echo $id; ?>');
    jobInfoStatus('<?php echo $id;?>');
    jobNotes('<?php echo $id; ?>');
    fetchForms('<?php echo $id; ?>');
    jobTasks('<?php echo $id; ?>');
    fetchJobHours('<?php echo $id; ?>');

    function jobInfo(id) {
        let urlAjax = "/api/job/get/?type&jobId=" + id;
        $.ajax({
            url: urlAjax,
            method: "GET",
            dataType: "json",
            beforeSend: function(xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');

                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },

            success: function(data) {
                try {
                    const newContent = `Job: ${data[0].project_name}`;
                    const h2Element = document.getElementById('jobTitle');
                    h2Element.innerHTML = newContent;

                    const newContent2 = `Job Number: ${data[0].job_number}`;
                    const h2Element2 = document.getElementById('jobNumber');
                    h2Element2.innerHTML = newContent2;

                    document.getElementById('date').value = data[0].date;
                    document.getElementById('project_email').value = data[0].project_email;
                    document.getElementById('project_phone').value = data[0].project_phone;
                    document.getElementById('job_comment').value = data[0].job_comment;
                    //document.getElementById('estimated_time').value = data[0].estimated_time;
                    document.getElementById('int_ext').value = data[0].int_ext;

                    const logged_by = data[0].logged_by;
                    if (logged_by == 1) {
                        document.getElementById('logged_by').value = 'Caroline';
                    } else if (logged_by == 2) {
                        document.getElementById('logged_by').value = 'Elliot';
                    } else if (logged_by == 3) {
                        document.getElementById('logged_by').value = 'Geraldine';
                    } else if (logged_by == 4) {
                        document.getElementById('logged_by').value = 'Tina';
                    } else if (logged_by == 5) {
                        document.getElementById('logged_by').value = 'Sarah';
                    } else if (logged_by == 6) {
                        document.getElementById('logged_by').value = 'Olivia';
                    } else if (logged_by == 7) {
                        document.getElementById('logged_by').value = 'James';
                    }

                    const int_ext = data[0].int_ext;
                    if (int_ext == 1) {
                        document.getElementById('int_ext').value = 'External';
                    } else if (int_ext == 2) {
                        document.getElementById('int_ext').value = 'Internal';
                    }

                    let buttonHTML = '';
                    const status = data[0].status;
                    if (status == 1) {
                        buttonHTML = '<button class="btn btn-secondary">Open</button>';
                    } else if (status == 2) {
                        buttonHTML = '<button class="btn btn-warning">Quote</button>';
                    } else if (status == 3) {
                        buttonHTML = '<button class="btn btn-warning">Quoted</button>';
                    } else if (status == 4) {
                        buttonHTML = '<button class="btn btn-success">Development</button>';
                    } else if (status == 5) {
                        buttonHTML = '<button class="btn btn-danger">Invoice</button>';
                    } else if (status == 6) {
                        buttonHTML = '<button class="btn btn-primary">Archive</button>';
                    }

                    // Agregar el botón al DOM
                    document.getElementById('status').innerHTML = buttonHTML;

                    const assignedStaff = document.getElementById('assignedStaff');
                    assignedStaff.innerHTML = ''; // Limpiar el contenido anterior

                    // Valor recibido de la API
                    const projectManagementFromAPI = data[0].project_management;

                    // Parsear el valor recibido para obtener los valores seleccionados
                    const selectedValues = projectManagementFromAPI.substring(1, projectManagementFromAPI.length - 1).split(',');

                    // Mostrar los IDs correspondientes
                    selectedValues.forEach(value => {
                        const id = value.trim();
                        const name = getStaffName(parseInt(id));
                        if (name) {
                            const label = document.createElement('label');
                            label.className = 'btn btn-secondary';
                            label.textContent = name;
                            label.style.marginRight = '5px'; // Añadir un margen derecho para separar los botones
                            assignedStaff.appendChild(label);
                        }
                    });


                } catch (error) {
                    //
                }
            }
        })
    }

    function getStaffName(id) {
        switch (id) {
            case 1:
                return 'Caroline';
            case 2:
                return 'Elliot';
            case 3:
                return 'Geraldine';
            case 4:
                return 'Tina';
            case 5:
                return 'Sarah';
            case 6:
                return 'Olivia';
            case 7:
                return 'James';
            default:
                return null;
        }
    }

    function jobInfoStatus(id) {
        let urlAjax = "/api/job/get/?type=historyStatus&historyStatus=" + id;

        let server = window.location.hostname;
        let url = "https://" + server + "/job-list/user/";
        let persons = {
            1: {
                name: 'Caroline',
                link: url + '1/'
            },
            2: {
                name: 'Elliot',
                link: url + '2/'
            },
            3: {
                name: 'Geraldine',
                link: url + '3/'
            },
            4: {
                name: 'Tina',
                link: url + '4/'
            },
            5: {
                name: 'Sarah',
                link: url + '5/'
            },
            6: {
                name: 'Olivia',
                link: url + '6/'
            },
            7: {
                name: 'James',
                link: url + '7/'
            },
        };

        $.ajax({
            url: urlAjax,
            method: "GET",
            dataType: "json",
            beforeSend: function(xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');

                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function(data) {
                if (!(data.error)) {

                    // Suponiendo que 'data' es un array de objetos con las propiedades status, user, date
                    // Primero, selecciona o crea el elemento donde se insertará la tabla
                    let tableContainer = document.getElementById('historyJobContainer');
                    if (!tableContainer) {
                        tableContainer = document.createElement('div');
                        tableContainer.id = 'historyJobContainer';
                        document.body.appendChild(tableContainer);
                    }

                    // Crear la tabla con clases de Bootstrap
                    let table = document.createElement('table');
                    table.className = 'table table-striped';

                    // Crear el encabezado de la tabla
                    let thead = document.createElement('thead');
                    let headerRow = document.createElement('tr');

                    let headers = ['Status', 'User', 'Date'];
                    headers.forEach(headerText => {
                        let th = document.createElement('th');
                        th.className = 'table-primary'; // Agregar la clase table-primary a los encabezados
                        th.appendChild(document.createTextNode(headerText));
                        headerRow.appendChild(th);
                    });

                    thead.appendChild(headerRow);
                    table.appendChild(thead);

                    // Crear el cuerpo de la tabla
                    let tbody = document.createElement('tbody');
                    data.forEach(item => {
                        let row = document.createElement('tr');

                        // Convertir el ID de estado en su nombre correspondiente
                        let statusText = '';
                        switch (item.status) {
                            case '1':
                                statusText = 'Open';
                                break;
                            case '2':
                                statusText = 'Quote';
                                break;
                            case '3':
                                statusText = 'Quoted';
                                break;
                            case '4':
                                statusText = 'Development';
                                break;
                            case '5':
                                statusText = 'Invoice';
                                break;
                            case '6':
                                statusText = 'Archive';
                                break;
                            default:
                                statusText = 'Unknown';
                        }

                        // Crear celda para el estado con el nombre correspondiente
                        let statusCell = document.createElement('td');
                        statusCell.appendChild(document.createTextNode(statusText));
                        row.appendChild(statusCell);

                        // Obtener el nombre del usuario y su enlace
                        let user = persons[item.user].name;
                        let userLink = persons[item.user].link;

                        // Crear celda para el nombre del usuario con enlace
                        let userCell = document.createElement('td');
                        let userAnchor = document.createElement('a');
                        userAnchor.setAttribute('href', userLink);
                        userAnchor.appendChild(document.createTextNode(user));
                        userCell.appendChild(userAnchor);
                        row.appendChild(userCell);

                        // Formatear la fecha en el formato dd/mm/yy hh:mm
                        let date = new Date(item.date);
                        let formattedDate = `${pad2(date.getDate())}/${pad2(date.getMonth() + 1)}/${date.getFullYear()} ${pad2(date.getHours())}:${pad2(date.getMinutes())}`;

                        // Crear celda para la fecha formateada
                        let dateCell = document.createElement('td');
                        dateCell.appendChild(document.createTextNode(formattedDate));
                        row.appendChild(dateCell);

                        tbody.appendChild(row);
                    });

                    table.appendChild(tbody);

                    // Limpiar el contenedor antes de añadir la nueva tabla
                    tableContainer.innerHTML = '';
                    tableContainer.appendChild(table);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }

    // Función para añadir un cero delante de números menores que 10
    function pad2(number) {
        return (number < 10 ? '0' : '') + number;
    }

    function jobNotes(id) {
    let urlAjax = "/api/job/get/?type=jobNotes&jobNotes=" + id;

    let server = window.location.hostname;
    let url = "https://" + server + "/job-list/user/";

    $.ajax({
        url: urlAjax,
        method: "GET",
        dataType: "json",
        beforeSend: function(xhr) {
            // Obtener el token del localStorage
            let token = localStorage.getItem('token');

            // Incluir el token en el encabezado de autorización
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function(data) {
            if (!data.error) {
                // Suponiendo que 'data' es un array de objetos con las propiedades note, idUser, date, nameCreated, nameModified, date_modified
                // Primero, selecciona o crea el contenedor donde se insertarán las notas
                let notesContainer = document.getElementById('notesContainer');
                if (!notesContainer) {
                    notesContainer = document.createElement('div');
                    notesContainer.id = 'notesContainer';
                    document.body.appendChild(notesContainer);
                }

                // Limpiar el contenedor antes de añadir las nuevas notas
                notesContainer.innerHTML = '';

                // Crear un div para cada nota y aplicar los estilos de Bootstrap
                data.forEach(item => {
                    let noteDiv = document.createElement('div');
                    noteDiv.className = 'alert alert-secondary'; // Estilos de Bootstrap
                    noteDiv.setAttribute('role', 'alert');

                    // Mostrar el nombre del usuario y la fecha en la misma línea
                    let userName = item.nameCreated;
                    let formattedDate = formatDate(item.date_created);

                    // Crear un párrafo que contenga "Created by: Nombre - Fecha"
                    let createdByParagraph = document.createElement('p');
                    createdByParagraph.innerHTML = `<strong>Created by:</strong> ${userName.split(' ')[0]} (${formattedDate})`;
                    noteDiv.appendChild(createdByParagraph);

                    // Mostrar la nota
                    let noteContent = document.createElement('p');
                    noteContent.innerHTML = item.note; // Usar innerHTML para interpretar el contenido HTML
                    noteDiv.appendChild(noteContent);

                    // Mostrar "Updated by: (nameModified) on (date_modified)" si existe nameModified
                    if (item.nameModified) {
                        let updatedByParagraph = document.createElement('p');
                        let formattedModifiedDate = formatDate(item.date_modified);
                        updatedByParagraph.innerHTML = `<strong>Updated by:</strong> ${item.nameModified} (${formattedModifiedDate})`;
                        noteDiv.appendChild(updatedByParagraph);
                    }

                    // Añadir botón para editar la nota
                    let editButton = document.createElement('a');
                    editButton.textContent = 'Edit Note';
                    editButton.href = `https://${window.location.hostname}/job-list/notes/update/${item.id}`;
                    editButton.className = 'btn btn-warning btn-sm mt-2';
                    noteDiv.appendChild(editButton);

                    // Añadir el div de la nota al contenedor
                    notesContainer.appendChild(noteDiv);
                });
            } else {
                let errorMessage = 'No data to show.';
                const h2Element2 = document.getElementById('errorNotesMessage');
                h2Element2.innerHTML = errorMessage;
                console.log("No notes to display.");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Manejar errores de la solicitud AJAX aquí
            console.error('Error fetching job notes:', errorThrown);
        }
    });
}

function formatDate(dateString) {
    let options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}


// Función auxiliar para formatear la fecha
function formatDate(dateString) {
    let date = new Date(dateString);
    let formattedDate = `${pad2(date.getDate())}/${pad2(date.getMonth() + 1)}/${date.getFullYear()} ${pad2(date.getHours())}:${pad2(date.getMinutes())}`;
    return formattedDate;
}

// Función auxiliar para asegurarse de que los números sean de dos dígitos (para el formato de fecha)
function pad2(number) {
    return (number < 10 ? '0' : '') + number;
}


    function fetchForms(id) {

        let server = window.location.hostname;
        let urlAjax = "https://" + server + "/api/job/get/?type=formJob&formJob=" + id;
        $.ajax({
            url: urlAjax,
            method: 'GET',
            dataType: 'json',
            beforeSend: function(xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');
                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function(data) {
                if (!(data.error)) {
                    $('#clientFormsJobs').show();
                    $('#clientFormsJobsTable').show();
                    let tableBody = $('#formTableBody');
                    tableBody.empty(); // Limpiar el cuerpo de la tabla

                    data.forEach(function(row) {
                        let categoryButton = row.wq1 !== null ? '<button type="button" class="btn btn-sm btn-success">WEBSITE</button>' :
                            row.sq1 !== null ? '<button type="button" class="btn btn-sm btn-primary">SOCIAL MEDIA</button>' :
                            row.bq1 !== null ? '<button type="button" class="btn btn-sm btn-dark">BRAND</button>' : '';

                        let formattedDate = moment(row.date).format('DD/MM/YYYY HH:mm');

                        let viewFormLink = '<a class="btn btn-sm btn-warning" href="https://' + window.location.hostname + '/form-list/view/' + row.id + '" role="button">View submission</a>';

                        let tableRow = '<tr>' +
                            '<td>' + categoryButton + '</td>' +
                            '<td>' + formattedDate + '</td>' +
                            '<td>' + viewFormLink + '</td>' +
                            '</tr>';

                        tableBody.append(tableRow);
                    });
            } else {
                    let errorMessage = 'No data to show.';
                    const h2Element2 = document.getElementById('errorFormMessage');
                    h2Element2.innerHTML =  errorMessage;
                }
            },
            error: function(xhr, status, error) {
                //
            }
        });
    }


    function jobTasks(id) {
    let server = window.location.hostname;
    let urlAjax = "https://" + server + "/api/planning/get/?type=taskJob&jobId=" + id;

    $.ajax({
        url: urlAjax,
        method: 'GET',
        dataType: 'json',
        beforeSend: function(xhr) {
            // Obtener el token del localStorage
            let token = localStorage.getItem('token');
            // Incluir el token en el encabezado de autorización
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function(data) {
            if (!(data.error)) {
                $('#clientTasks').show();
                $('#clientTasksTable').show();
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td>' + data[i].name_task + '</td>';
                    html += '<td><a href="/planning-list/view/user/'+data[i].idUser+'/">' + data[i].name + '</a></td>';
                    html += '<td>';
                    if (data[i].status == "1") {
                        html += '<button type="button" class="btn btn-sm btn-danger" onclick="changeStatusPlanning(' + data[i].id + ',' + data[i].status + ')">To Do</button>';
                    } else if (data[i].status == "2") {
                        html += '<button type="button" class="btn btn-sm btn-dark" onclick="changeStatusPlanning(' + data[i].id + ',' + data[i].status + ')">Completed</button>';
                    }
                    html += '</td>';
                    html += '<td>' + data[i].hours + ' hours</td>';
                    html += '<td>' + moment(data[i].date_created).format('DD/MM/YYYY hh:mm') + '</td>'
                    html += '</tr>';
                }
                $('#tasksTableBody').html(html); // Cambiado para apuntar a '#tasksTableBody' directamente
            } else {
                let errorMessage = 'No data to show.';
                const h2Element2 = document.getElementById('errorTaskMessage');
                h2Element2.innerHTML = errorMessage;
            }
        },
        error: function(xhr, status, error) {
            //
        }
    });
}

function fetchJobHours(jobId) {
    if (!jobId) {
        document.getElementById('jobHoursInfo').style.display = 'none';
        return;
    }

    let urlAjax = "https://" + window.location.hostname + "/api/job/get/?type=jobTime&jobId=" + jobId;

    $.ajax({
        url: urlAjax,
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function(data) {
            if (data) {
                var estimatedTime = parseFloat(data[0].estimated_time) || 0;
                var totalTaskHours = parseFloat(data[0].total_task_hours) || 0;
                var availableHours = estimatedTime - totalTaskHours;

                document.getElementById('hoursAvailable').innerText = estimatedTime;
                document.getElementById('hoursAssigned').innerText = totalTaskHours;
                document.getElementById('availableHours').innerText = availableHours;
                document.getElementById('jobHoursInfo').style.display = 'block';
            }
        },
        error: function(xhr, status, error) {
            //console.error("Error fetching job hours:", error);
            document.getElementById('jobHoursInfo').style.display = 'none';
        }
    });
}

 // AJAX PROCESS > PHP API : PER ACTUALIZAR FORMULARIS A LA BD
 function changeStatusPlanning(id, status) {

// Obtener los datos del formulario como un objeto JSON
var formData = {
    status: status,
    id: id,
};
$.ajax({
    contentType: "application/json", // Establecer el tipo de contenido como JSON
    type: "PUT",
    url: "https://" + window.location.hostname + "/api/planning/put/?type=statusTask&taskId=" + id,
    dataType: "JSON",
    beforeSend: function(xhr) {
        // Obtener el token del localStorage
        let token = localStorage.getItem('token');

        // Incluir el token en el encabezado de autorización
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    },
    data: JSON.stringify(formData),
    success: function(response) {
        if (response.status == "success") {
            // Add response in Modal body
            $("#updateOk").show();
            $("#updateErr").hide();

            // Recargar la tabla después de actualizar los datos
            jobTasks('<?php echo $id; ?>');
        } else {
            $("#updateErr").show();
            $("#updateOk").hide();
        }
    },
});
}

</script>