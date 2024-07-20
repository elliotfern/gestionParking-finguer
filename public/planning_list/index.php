<?php
// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1, 4); // Caroline, Tina
?>

<h1>Planning tasks</h1>

<a href="<?php echo APP_WEB;?>/planning-list/new/" class="btn btn-primary" role="button" aria-disabled="true">Create New Task</a>

<div class="container-fluid">
    <!-- Primera fila con 3 tablas -->
    <div class="table-responsive" style="margin-top:40px;margin-bottom:40px">
        <table class="table table-striped" id="planning_table">
            <thead class="table-primary">
                <tr>
                    <th>Employee</th>
                    <th>View tasks</th>
                    <th>Assign task</th>
                </tr>
            </thead>
            <tbody id="planning_table_body"></tbody>
        </table>
    </div>
</div>

<hr>
<h3>Active Tasks</h3>
<div class="table-responsive" style="margin-top:40px;margin-bottom:40px;display:none" id="planningTaskActive">
    <table class="table table-striped" id="planningTaskActiveTable">
        <thead class="table-primary">
            <tr>
                <th>Task Name</th>
                <th>Employee</th>
                <th>Job Number</th>
                <th>Business Name</th>
                <th>Status</th>
                <th>Time assigned</th>
                <th>Date assign</th>
            </tr>
        </thead>
        <tbody id="planningTaskActiveBody"></tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Cargar empleados y sus tareas al cargar la página
        loadEmployeesAndTasks();
        loadActiveTasks();
    });

    function loadEmployeesAndTasks() {
        var urlAjax = "https://" + window.location.hostname + "/api/users/get/?type=users";
        $.ajax({
            url: urlAjax,
            method: "GET",
            dataType: "json",
            beforeSend: function(xhr) {
                let token = localStorage.getItem('token');
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function(data) {
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td>' + data[i].name + '</td>';
                    html += '<td><a href="/planning-list/view/user/' + data[i].id + '/" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">View Tasks</a></td>';
                    html += '<td><a href="/planning-list/new/' + data[i].id + '/" class="btn btn-primary btn-sm" role="button" aria-disabled="true">Assign job to ' + data[i].name + '</a></td>';
                    html += '</tr>';
                }
                $('#planning_table_body').html(html);
            },
            error: function() {
                console.error('Error fetching users data');
            }
        });
    }

    function loadActiveTasks() {
        var urlAjax = "https://" + window.location.hostname + "/api/planning/get/?type=planningTasksActive";
         // Destruir DataTable si ya está inicializada
         if ($.fn.DataTable.isDataTable('#planningTaskActiveTable')) {
           $('#planningTaskActiveTable').DataTable().clear().destroy();
        }

        $.ajax({
            url: urlAjax,
            method: "GET",
            dataType: "json",
            beforeSend: function(xhr) {
                let token = localStorage.getItem('token');
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function(data) {
                if (data.length === 0) {
                    $('#planningTaskActiveTable').hide();
                } else {
                    if (!(data.error)) {

                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<tr>';
                            html += '<td><strong>' + data[i].name_task + '</strong></td>';
                            html += '<td><a href="https://' + window.location.hostname + '/planning-list/view/user/' + data[i].idUser + '">' + data[i].name.split(' ')[0] + '</a></td>';
                            html += '<td><a href="https://' + window.location.hostname + '/job-list/view/' + data[i].jobId + '">' + data[i].job_info + '</a></td>';
                            html += '<td><a href="https://' + window.location.hostname + '/client-list/view/' + data[i].idClient + '">' + data[i].business_name + '</a></td>';
                            html += '<td>';
                            if (data[i].status == "1") {
                                html += '<button type="button" class="btn btn-sm btn-danger" onclick="changeStatusPlanning(' + data[i].id + ',' + data[i].status + ')">To Do</button>';
                            } else if (data[i].status == "2") {
                                html += '<button type="button" class="btn btn-sm btn-dark" onclick="changeStatusPlanning(' + data[i].id + ',' + data[i].status + ')">Completed</button>';
                            }
                            html += '</td>';
                            html += '<td>' + data[i].hours + ' hours</td>';
                            html += '<td>' + moment(data[i].date_created).format('DD/MM/YYYY HH:mm') + '</td>';
                            html += '</tr>';
                        }
                        $('#planningTaskActiveTable tbody').html(html);
                        $('#planningTaskActive').show();


                        $('#planningTaskActiveTable').DataTable({
                            keys: true,
                            stateSave: true, // Habilitar el guardado del estado
                            "columnDefs": [
                                { "orderable": false, "targets": 0 } // Deshabilitar la ordenación en la primera columna (índice 0)
                            ]
                        });

                       
                    } else {
                        let errorMessage = 'This employee doesn\'t have any task assign.';
                        const h2Element2 = document.getElementById('errorMessage');
                        h2Element2.innerHTML = errorMessage;
                    }
                }
            },
            error: function() {
                let errorMessage = 'There was an error retrieving the data.';
                const h2Element2 = document.getElementById('errorMessage');
                h2Element2.innerHTML = errorMessage;
            }
        });
    }

    function changeStatusPlanning(id, status) {
        var formData = {
            status: status,
            id: id,
        };
        $.ajax({
            contentType: "application/json",
            type: "PUT",
            url: "https://" + window.location.hostname + "/api/planning/put/?type=statusTask&taskId=" + id,
            dataType: "json",
            beforeSend: function(xhr) {
                let token = localStorage.getItem('token');
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            data: JSON.stringify(formData),
            success: function(response) {
                if (response.status == "success") {
                    $("#updateOk").show();
                    $("#updateErr").hide();
                    loadActiveTasks(); // Actualizar tareas activas después del cambio
                } else {
                    $("#updateErr").show();
                    $("#updateOk").hide();
                }
            },
            error: function() {
                $("#updateErr").show();
                $("#updateOk").hide();
            }
        });
    }
</script>
