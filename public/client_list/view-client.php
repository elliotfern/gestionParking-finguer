<?php
$id = $params['id'];

// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserId = array(1,4); // Caroline

$allowedUserId_All = array(1,2,3,4,5,6,7); // All team
?>

<div class="container-fluid">
<h1>Client info</h1>
<h2 id="clientTitle"></h2>


<?php
if (in_array($user_id, $allowedUserId)) {
    echo '<div class="col-3" style="margin-top:20px;margin-bottom:20px">
    <a class="btn btn-primary" href="'. APP_SERVER .'/client-list/update/'. $id.'" role="button">Update client information</a></div>';
}

if (in_array($user_id, $allowedUserId_All)) {
    ?>
    <div class="row g-4 quadre" style="margin-bottom:30px">
    <div class="col-6">
        <span class="bold">Client Name:</span>
        <input type="text" name="client_name" id="client_name" class="form-control" readonly>
    </div>
    
    <div class="col-6">
    <span class="bold">Business Name:</span>
    <input type="name" name="business_name" id="business_name" class="form-control" readonly>
    </div>

    <hr>

    <?php
     if (in_array($user_id, $allowedUserId)) {
    ?>
    <div style="display:none" id="displayAdmin1">
        <div class="col-6">
        <span class="bold">Business Address:</span>
        <input type="text" name="business_address" id="business_address" class="form-control" readonly>
        </div>

        <div class="col-6">
        <span class="bold">Billing Address:</span>
        <input type="text" name="billing_address" id="billing_address" class="form-control" readonly>
        </div>

        <hr>
    </div>
    <?php }
    ?>
    
    <div class="col-6">
    <span class="bold">E-mail:</span>
    <input type="text" name="email" id="email" class="form-control" readonly>
    </div>

    <div class="col-6">
    <span class="bold">Phone:</span>
    <input type="text" name="phone" id="phone" class="form-control" readonly>
    </div>

    <div class="col-6">
    <span class="bold">Mobile:</span>
    <input type="text" name="mobile" id="mobile" class="form-control" readonly>
    </div>

    <hr>

    <?php
     if (in_array($user_id, $allowedUserId)) {
    ?>
    <div style="display:none" id="displayAdmin2">
        <div class="col-6">
        <span class="bold">VAT Number:</span>
        <input type="text" name="vat_number" id="vat_number" class="form-control" readonly>
        </div>

        <div class="col-6">
        <span class="bold">PO Number:</span>
        <input type="text" name="po_number" id="po_number" class="form-control" readonly>
        </div>
    </div>
    <?php }
    ?>

</div>
<?php } ?>

<h2>Client Jobs:</h2>

<div id="projectTableContainer"></div>

</div>

<script>
clientInfo('<?php echo $id; ?>', '<?php echo $user_id; ?>')

function clientInfo(clientId, userId) {
  let urlAjax = "/api/clients/get/?clientInfo=" + clientId;
  $.ajax({
    url: urlAjax,
    method: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      // Obtener el token del localStorage
      let token = localStorage.getItem('token');

      // Incluir el token en el encabezado de autorización
      xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    },

    success: function (data) {
      try {
        const newContent = `${data.client_name} (${data.business_name})`;
        const h2Element = document.getElementById('clientTitle');
        h2Element.innerHTML = newContent;

        if (userId == 1){
            document.getElementById('displayAdmin1').style.display = 'block';
            document.getElementById('displayAdmin2').style.display = 'block';
            document.getElementById('vat_number').value = data.vat_number;
            document.getElementById('po_number').value = data.po_number;
            document.getElementById('business_address').value = data.business_address;
            document.getElementById('billing_address').value = data.billing_address;
        }

        document.getElementById('client_name').value = data.client_name;
        document.getElementById('business_name').value = data.business_name;
        document.getElementById('email').value = data.email;
        document.getElementById('phone').value = data.phone;
        document.getElementById('mobile').value = data.mobile;

      } catch (error) {
        //
      }
    }
  })
}

// Función para obtener los datos de los proyectos del cliente desde la API
function getProjectsByClient(clientId) {
    $.ajax({
        url: "/api/clients/get/?clientId=" + clientId,
        method: "GET",
        dataType: "JSON",
        beforeSend: function(xhr) {
            // Obtener el token del localStorage
            let token = localStorage.getItem('token');
            // Incluir el token en el encabezado de autorización
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
        success: function(response) {
            // Llamar a la función para crear la tabla con los datos de proyectos
            createProjectTable(response);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching projects:", error);
        }
    });
}

// Función para crear la tabla con los datos de los proyectos
function createProjectTable(projects) {
     // Verificar si hay datos
     if (projects && projects.length > 0) {
        var tableHtml = "<table class='table table-striped'>";
        tableHtml += "<thead class='table-primary'><tr><th>Job &darr;</th><th>Job Name</th><th>Status</th><th>Date</th></tr></thead>";
        tableHtml += "<tbody>";

        projects.forEach(function(project) {
            tableHtml += "<tr>";
            tableHtml += "<td><a href='https://" + window.location.hostname + "/job-list/view/" + project.id + "'>" + project.job_number + "</a></td>"; // Agregar enlace al proyecto
            tableHtml += "<td>" + project.project_name + "</td>";
            tableHtml += "<td>";
            // Lógica condicional para mostrar el estado del proyecto como texto
            let statusText = '';
            switch (project.status) {
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

            tableHtml += statusText; // Agregar el estado del proyecto como texto
                tableHtml += "<td>" +  moment(project.date).format('DD/MM/YYYY');+ "</td>";
                tableHtml += "</tr>";
            });

        tableHtml += "</tbody></table>";

        $("#projectTableContainer").html(tableHtml);
    } else {
        // Si no hay datos, mostrar un mensaje o limpiar el contenedor
        $('#projectTableContainer').html('<p>No Jobs found for this client.</p>');
    }
}

// Llamar a la función para obtener los datos de los proyectos del cliente
getProjectsByClient(<?php echo $id;?>);

</script>
