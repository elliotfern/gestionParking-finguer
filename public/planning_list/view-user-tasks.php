<?php
$userId = $params['userId'];
?>

<div class="container-fluid">
    <h1>Planning tasks</h1>
    <h3 id="userTitle"></h3>

    <div class="btn-group-toggle" data-toggle="buttons">
        <a href="<?php echo APP_SERVER; ?>/planning-list/new/<?php echo $userId; ?>/" class="btn btn-primary" role="button">Assign new Task to this employee</a>

        <div class="table-responsive" style="margin-top:40px;margin-bottom:40px;display:none" id="planningTaskUser">
            <table class="table table-striped" id="planningTaskUserTable">
                <thead class="table-primary">
                    <tr>
                        <th>Task Name</th>
                        <th>Job Number</th>
                        <th>Business Name</th>
                        <th>Status</th>
                        <th>Time assigned</th>
                        <th>Date assign</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="errorMessage" style="margin-top:20px;margin-bottom:20px"></div>

<script>
    function changeStatusPlanning(id, status) {
        var formData = {
            status: status,
            id: id,
        };
        $.ajax({
            contentType: "application/json",
            type: "PUT",
            url: "https://" + window.location.hostname + "/api/planning/put/?type=statusTask&taskId=" + id,
            dataType: "JSON",
            beforeSend: function(xhr) {
                let token = localStorage.getItem('token');
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            data: JSON.stringify(formData),
            success: function(response) {
                if (response.status == "success") {
                    $("#updateOk").show();
                    $("#updateErr").hide();
                    jobTasks(<?php echo $userId; ?>);
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

    function jobTasks(idUser) {

      // Destruir DataTable si ya está inicializada
        if ($.fn.DataTable.isDataTable('#planningTaskUserTable')) {
           $('#planningTaskUserTable').DataTable().clear().destroy();
        }

        var urlAjax = "https://" + window.location.hostname + "/api/planning/get/?type=planningTasks&userId=" + idUser;
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
                    $('#planningTaskUser').hide();
                } else {
                    if (!(data.error)) {
                        const newContent = data[0].name;
                        const h2Element = document.getElementById('userTitle');
                        h2Element.innerHTML = "Employee: " + newContent;

                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<tr>';
                            html += '<td><strong>' + data[i].name_task + '</strong></td>';
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
                        $('#planningTaskUserTable tbody').html(html);
                        $('#planningTaskUser').show();


                        $('#planningTaskUserTable').DataTable({
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

    $(document).ready(function() {
        jobTasks(<?php echo $userId; ?>);
    });
</script>