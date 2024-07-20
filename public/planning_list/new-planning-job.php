<?php
$jobId = isset($params['jobId']) ? intval($params['jobId']) : null;
$cookieUserId = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;
?>

<div class="container-fluid">
    <h1>New Planning task</h1>

    <div class="alert alert-success" id="creaOk" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>New planning create OK!</strong></h4>
        <h6>New planning create successfully.</h6>
    </div>

    <div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>Error</strong></h4>
        <h6>Some data is not correct.</h6>
    </div>

    <form action="" method="POST" id="newPlanning">

        <div class="row g-4 quadre">

            <div class="col-6">
                <label for="userId" class="bold">Assign to:</label>
                <select class="form-select" name="userId" id="userId">

                </select>
                <div class="invalid-feedback" id="userId_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="date" class="bold">Task name: </label>
                <input type="text" name="name_task" id="name_task" class="form-control" value="">
                <div class="invalid-feedback" id="name_task_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="jobId" class="bold">Job</label>
                <select class="form-select" name="jobId" id="jobId">
                    <option value='' selected>Select a Job:</option>
                    <?php
                    global $conn;
                    $sql = "SELECT CONCAT(j.job_number, ' || ', j.project_name) AS job_info, j.id
                            FROM job_list AS j
                            WHERE j.status BETWEEN 1 AND 5
                            ORDER BY j.job_number DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                       // Verificar si jobId está definido y es igual al id actual
                        $selected = isset($jobId) && $jobId == $row['id'] ? 'selected' : '';

                        // Mostrar la opción con el valor y el nombre del trabajo
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['job_info'] . "</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback" id="jobId_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <hr>

            <div id="jobHoursInfo" style="display:none; margin-top:20px;">
                <p><strong>Number of hours available for this job:</strong> <span id="hoursAvailable"></span></p>
                <p><strong>Number of hours assigned:</strong> <span id="hoursAssigned"></span></p>
                <p><strong>Available hours:</strong> <span id="availableHours"></span></p>
            </div>

            <div class="col-6">
                <label for="hours" class="bold">Assign task hours: </label>
                <input type="number" name="hours" id="hours" class="form-control" value="">
                <div class="invalid-feedback" id="hours_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <input type="hidden" name="jobName" id="jobName">
            <input type="hidden" name="assigned_by" id="assigned_by" value="<?php echo $cookieUserId;?>">

            <div class="col-12 d-flex justify-content-between">
                <button type="submit" id="btnAddTask" class="btn btn-primary">Assign new task</button>
                <?php if (!isset($jobId)) {
                    echo '<a class="btn btn-secondary" href="'.APP_SERVER.'/planning-list/" role="button">Come back to the Planning</a>
                     </div>';
                } else {
                    echo '<a class="btn btn-secondary" href="'.APP_SERVER.'/job-list/view/'.$jobId.'" role="button">Come back to the Job page</a>
                    </div>';
                }
                ?>
            </div>

        </div>
    </form>
</div>

<script>
     fetchJobHours('<?php echo $jobId;?>');

document.addEventListener("DOMContentLoaded", function() {
    var select = document.getElementById('jobId');
    select.addEventListener('change', function() {
        updateJobName();
        fetchJobHours(select.value);
    });
});

function updateJobName() {
    var select = document.getElementById('jobId');
    var jobName = select.options[select.selectedIndex].getAttribute('data-job-name');
    if (jobName) {
        document.getElementById('jobName').value = jobName;
    }
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
            console.error("Error fetching job hours:", error);
            document.getElementById('jobHoursInfo').style.display = 'none';
        }
    });
}

// Validar el valor de horas antes de enviar el formulario
document.getElementById('btnAddTask').addEventListener('click', function(event) {
    var hoursInput = document.getElementById('hours');
    var availableHours = parseFloat(document.getElementById('availableHours').innerText) || 0;
    var assignedHours = parseFloat(hoursInput.value);

    if (isNaN(assignedHours)) {
        document.getElementById('hours_error').innerText = "* Invalid input.";
        event.preventDefault();
        return;
    }

    if (assignedHours > availableHours) {
        document.getElementById('hours_error').innerText = "* Assigned hours cannot exceed available hours.";
        event.preventDefault();
    } else {
        document.getElementById('hours_error').innerText = "";
        formInsert(event, "newPlanning", "/api/planning/post/?type=newPlanning");
    }
});

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

// Función para poblar el select de usuarios
async function populateUserSelect() {
  const users = await fetchUsers(); // Obtener la lista de usuarios

  // Obtener el select de usuarios
  const select = document.getElementById('userId');

  // Limpiar opciones existentes
  select.innerHTML = '';

  // Agregar una opción predeterminada
  const defaultOption = document.createElement('option');
  defaultOption.value = '0';
  defaultOption.textContent = 'Select an option:';
  select.appendChild(defaultOption);

  // Agregar una opción por cada usuario
  users.forEach(user => {
    const option = document.createElement('option');
    option.value = user.id; // Establecer el valor del usuario como el ID
    option.textContent = user.name; // Establecer el texto del usuario como el nombre
    select.appendChild(option);
  });
}

// Llamar a la función para poblar el select de usuarios cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', populateUserSelect);
</script>
