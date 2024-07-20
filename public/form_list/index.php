<h1>Client Forms</h1>

<div class="btn-group-toggle" data-toggle="buttons" style="margin-top:20px;margin-bottom:20px">
    <a href="<?php echo APP_SERVER;?>/form" target="_blank" class="btn btn-secondary" role="button"><i class="bi bi-box-arrow-up-right"></i> Website / Brand / Social Forms</a>
</div>

<div class="data-table-container">
    <table id="formTable" class="table table-striped">
        <thead class="table-primary">
            <tr>
                <th>Client</th>
                <th>Job</th>
                <th>Business Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Category</th>
                <th>View form</th>
            </tr>
        </thead>
        <tbody id="formTableBody">
        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    fetchJobs().then(function () {
        fetchForms();
    });
});

// Suponiendo que la lista de jobs se obtiene de una API y se almacena en esta variable
var jobsList = [];

// Función para obtener la lista de jobs desde la API
function fetchJobs() {
    let server2 = window.location.hostname;
    let urlAjax2 = "https://" + server2 + "/api/job/get/?type=allJobs";
    return $.ajax({
        url: urlAjax2,
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            // Obtener el token del localStorage
            let token = localStorage.getItem('token');
            // Incluir el token en el encabezado de autorización
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function (data) {
            jobsList = data; // Almacena la lista de jobs
        },
        error: function (xhr, status, error) {
            console.error("Error al obtener los jobs:", error);
        }
    });
}

// Función para obtener las formas y llenar la tabla
function fetchForms() {
    let server = window.location.hostname;
    let urlAjax = "https://" + server + "/api/form/get/?type=allForms";
    $.ajax({
        url: urlAjax,
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
            // Obtener el token del localStorage
            let token = localStorage.getItem('token');
            // Incluir el token en el encabezado de autorización
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function (data) {
            let tableBody = $('#formTableBody');
            tableBody.empty(); // Limpiar el cuerpo de la tabla
            data.forEach(function (row) {
                let jobOptions = '<option value="0">No job</option>'; // Opción por defecto
                jobsList.forEach(function (job) {
                    jobOptions += '<option value="' + job.id + '"' + (job.id == row.jobId ? ' selected' : '') + '>' + job.job_info + '</option>';
                });
                
                // Si no hay coincidencia, selecciona "No job"
                if (!jobsList.some(job => job.id == row.jobId)) {
                    jobOptions = jobOptions.replace('value="0"', 'value="0" selected');
                }

                let jobSelect = '<form id="updateJob" method="POST" action="" data-id="' + row.id + '"><input type="hidden" id="id" name="id" value="' + row.id + '"><select class="form-select jobSelect" name="job" style="width: 300px;" data-row-id="' + row.id + '">' + jobOptions + '</select></form>';
                let categoryButton = row.wq1 !== null ? '<button type="button" class="btn btn-sm btn-success">WEBSITE</button>' :
                    row.sq1 !== null ? '<button type="button" class="btn btn-sm btn-primary">SOCIAL MEDIA</button>' :
                    row.bq1 !== null ? '<button type="button" class="btn btn-sm btn-dark">BRAND</button>' : '';
                let tableRow = '<tr>' +
                    '<td>' + row.client_name + '</td>' +
                    '<td>' + jobSelect + '</td>' +
                    '<td>' + row.company_name + '</td>' +
                    '<td>' + row.email + '</td>' +
                    '<td>' + moment(row.date).format('DD/MM/YYYY HH:mm') + '</td>' +
                    '<td>' + categoryButton + '</td>' +
                    '<td><a class="btn btn-sm btn-warning" href="https://' + window.location.hostname + '/form-list/view/' + row.id + '" role="button">View submission</a></td>' +
                    '</tr>';
                tableBody.append(tableRow);
            });

            // Agregar evento change a los dropdowns
            $('.jobSelect').on('change', function() {
                let jobId = $(this).val();
                let rowId = $(this).data('row-id');
                updateJob(rowId, jobId);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al obtener los forms:", error);
        }
    });
}

// Función para actualizar el job en la base de datos
function updateJob(rowId, jobId) {
    let server = window.location.hostname;
    let urlAjax = "https://" + server + "/api/form/put/?type=updateJobForm";
    $.ajax({
        url: urlAjax,
        method: 'PUT',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({ id: rowId, jobId: jobId }),
        beforeSend: function (xhr) {
            // Obtener el token del localStorage
            let token = localStorage.getItem('token');
            // Incluir el token en el encabezado de autorización
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function (response) {
            console.log("Job updated successfully:", response);
            fetchForms();
        },
        error: function (xhr, status, error) {
            console.error("Error updating job:", error);
        }
    });
}
</script>
