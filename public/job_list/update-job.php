<?php
$id = $params['id'];

// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1); // Caroline
?>

<div class="container-fluid">
<h1>Update Job</h1>
<h2 id="project_nameTitle"></h2>
<h5><span id="numberJobTitle">Job Number: <a id="jobLink" href="#"></a></span></h5>

<div class="alert alert-success" id="creaOk" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Updated job OK!</strong></h4>
                  <h6>Job updated successfully.</h6>
</div>
          
<div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Error</strong></h4>
                  <h6>Check the fields, some information is not correct.</h6>
</div>

<form action="" method="POST" id="updateJob">
<div class="row g-4 quadre">
    <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                    
    <div class="col-6">
        <label class="bold" for="date">Date:</label>
        <input type="date" name="date" id="date" class="form-control" value="">
        <div class="invalid-feedback" id="date_error" style="display:block!important">
            * Required
        </div>
    </div>

    <div class="col-6">
        <label class="bold" for="logged_by">Logged by:</label>
        <select class="form-select" name="logged_by" id="logged_by">
            <option selected value="0">Select an option:</option>
        </select>
        <div class="invalid-feedback" id="logged_by_error" style="display:block!important">
            * Required
        </div>
    </div>
                    
    <div class="col-6">
        <label class="bold" for="int_ext">Type:</label>
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
        <label class="bold" for="project_name">Project name:</label>
        <input type="text" name="project_name" id="project_name" class="form-control">
        <div class="invalid-feedback" id="project_name_error" style="display:block!important">
            * Required
        </div>
    </div>

    <div class="col-6">
        <label class="bold" for="client">Client:</label>
        <select class="js-example-responsive" style="width: 100%" name="client" id="client">
        </select>
        <div class="invalid-feedback" id="client_error" style="display:block!important">
            * Required
        </div>
    </div>

    <hr>

    <?php if (intval($user_id) == intval($allowedUserIds)) {

        echo '<div class="col-6">
            <label class="bold" for="estimated_time" class="bold">Estimated time hrs:</label>
            <input type="text" name="estimated_time" id="estimated_time" class="form-control">
        </div>
        
        <hr>';
    }?>


    <div class="col-12">
        <label class="bold" for="job_comment">Job comment (optional):</label>
        <textarea class="form-control" name="job_comment" id="job_comment" rows="5" value=""></textarea>
    </div>

    <div class="col-6">
        <label class="bold" for="project_email">Project email (optional):</label>
        <input type="text" name="project_email" id="project_email" class="form-control">
    </div>

    <div class="col-6">
        <label class="bold" for="project_phone">Project phone (optional):</label>
        <input type="text" name="project_phone" id="project_phone" class="form-control">
    </div>

    <hr>

    <div class="form-group">
        <label class="bold" for="project_management">Staff Assigned:</label><br>
        <div class="btn-group-toggle" data-toggle="buttons" id="staffAssignedContainer">
            <!-- Aquí se generarán los botones dinámicamente -->
        </div>
    </div>

    <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Job</button>
                <a class="btn btn-secondary" href="" role="button" id="btnComeBack">Come back to the Job</a>
            </div>
</div>
    
</form>
</div>

<style>
    /* Adjust the height of the select box */
    .select2-container--default .select2-selection--single {
        height: 38px;
    }

    /* Adjust the line-height to vertically center the text */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }

    /* Adjust the dropdown height */
    .select2-dropdown {
        max-height: 400px;
    }

    /* Allow the dropdown to scroll */
    .select2-results__options {
        max-height: 400px;
        overflow-y: auto;
    }

    /* Hide the add new client form initially */
    #add-client-form {
        display: none;
    }

</style>

<script>
$(document).ready(function() {
    $('#client').select2();
});

async function fetchUsers() {
  const server = window.location.hostname;
  const apiUrl = `https://${server}/api/users/get/?type=users`;

  try {
    const response = await fetch(apiUrl, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    });

    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function generateUserSelectAndButtons() {
  const users = await fetchUsers();

  const selectLoggedBy = document.getElementById('logged_by');
  selectLoggedBy.innerHTML = '';

  const defaultOption = document.createElement('option');
  defaultOption.value = '0';
  defaultOption.textContent = 'Select an option:';
  selectLoggedBy.appendChild(defaultOption);

  users.forEach(user => {
    const option = document.createElement('option');
    option.value = user.id;
    option.textContent = user.name.split(' ')[0];;
    selectLoggedBy.appendChild(option);
  });

  const staffAssignedContainer = document.getElementById('staffAssignedContainer');
  staffAssignedContainer.innerHTML = '';

  users.forEach(user => {
    const label = document.createElement('label');
    label.classList.add('btn', 'btn-secondary', 'm-1');

    const input = document.createElement('input');
    input.type = 'checkbox';
    input.name = 'project_management[]';
    input.value = user.id;
    input.autocomplete = 'off';

    label.appendChild(input);
    label.appendChild(document.createTextNode(' ' + user.name.split(' ')[0]));

    staffAssignedContainer.appendChild(label);
  });
}

async function clientInfo(id, userId) {
  let urlAjax = "/api/job/get/?type=job&job=" + id;
  try {
    const response = await fetch(urlAjax, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    });

    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }

    const data = await response.json();
    const clientData = data[0];

    document.getElementById('project_nameTitle').textContent = "Job: " + clientData.project_name;

    const jobUrl = `https://${window.location.hostname}/job-list/view/${clientData.id}`;
    // Obtener el enlace y actualizar su href y contenido
    const jobLinkElement = document.getElementById('jobLink');
    jobLinkElement.href = jobUrl;
    jobLinkElement.textContent = clientData.job_number;

    let comeBackButton = document.getElementById('btnComeBack');
      comeBackButton.href = jobUrl;

    document.getElementById('project_name').value = clientData.project_name;
    document.getElementById('date').value = clientData.date;
    document.getElementById('logged_by').value = clientData.logged_by;

    // Establecer el valor seleccionado en select2
    $('#client').val(clientData.client);
    $('#client').trigger('change');

    document.getElementById('project_email').value = clientData.project_email;
    document.getElementById('project_phone').value = clientData.project_phone;
    document.getElementById('job_comment').value = clientData.job_comment;

    if (userId == 1) {
      document.getElementById('estimated_time').value = clientData.estimated_time;
    }

    document.getElementById('int_ext').value = clientData.int_ext;

    const projectManagementFromAPI = clientData.project_management;
    const selectedValues = projectManagementFromAPI.substring(1, projectManagementFromAPI.length - 1).split(',');

    selectedValues.forEach(value => {
      const checkbox = document.querySelector(`input[type="checkbox"][value="${value.trim()}"]`);
      if (checkbox) {
        checkbox.checked = true;
      }
    });

  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function initializeForm() {
  await generateUserSelectAndButtons();
  clientInfo('<?php echo $id; ?>', '<?php echo $user_id; ?>');
}

initializeForm();

document.getElementById("updateJob").addEventListener("submit", function(event) {
  event.preventDefault();

  const selectedValues = [];
  const checkboxes = document.querySelectorAll('input[type="checkbox"][name="project_management[]"]:checked');
  checkboxes.forEach(function(checkbox) {
    selectedValues.push(checkbox.value);
  });

  const formattedString = '{' + selectedValues.join(',') + '}';

  const formData = Object.fromEntries(new FormData(this));
  formData["project_management"] = formattedString;

  const url = "/api/job/put/?type=updateJob";
  const jsonData = JSON.stringify(formData);

  $.ajax({
    contentType: "application/json",
    type: "PUT",
    url: url,
    dataType: "JSON",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    },
    data: jsonData,
    success: function (response) {
      if (response.status == "success") {
        $("#creaOk").show();
        $("#creaErr").hide();
        $(".invalid-feedback").text('');
        $("input[type='text']").css("border-color", "");
        $("select").css("border-color", "");
      } else {
        $("#creaErr").show();
        $("#creaOk").hide();

        if (response.errors) {
          $.each(response.errors, function(key, value) {
            $("#" + key + "_error").html('<strong>* ' + value + '</strong>');
            $("#" + key).css("border-color", "red");
          });
        } else {
          alert("Error: " + response.message);
        }
      }
    },
  });
});
</script>
