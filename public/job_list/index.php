<h1>Job list</h1>

<div class="col-3" style="margin-top:20px;margin-bottom:20px">
    <a class="btn btn-primary" href="<?php echo APP_SERVER;?>/job-list/new" role="button">Create new Job</a>
</div>

<!-- Botón de Bootstrap para actualizar la tabla -->
<button id="btnRefresh" onclick="refreshTable()" class="btn btn-success">Refresh data</button>

<hr>
<p class="bold">Sort jobs by Status:</p>
<div class="btn-group-toggle" data-toggle="buttons">
<a href="<?php echo APP_SERVER;?>/job-list/" class="btn btn-warning" role="button">All</a>
  <a href="<?php echo APP_SERVER;?>/job-list/status/1" class="btn btn-secondary" role="button">Open</a>
  <a href="<?php echo APP_SERVER;?>/job-list/status/2" class="btn btn-secondary" role="button">Quote</a>
  <a href="<?php echo APP_SERVER;?>/job-list/status/3" class="btn btn-secondary" role="button">Quoted</a>
  <a href="<?php echo APP_SERVER;?>/job-list/status/4" class="btn btn-secondary" role="button">Development</a>
  <a href="<?php echo APP_SERVER;?>/job-list/status/5" class="btn btn-secondary" role="button">Invoice</a>
  <a href="<?php echo APP_SERVER;?>/job-list/status/6" class="btn btn-secondary" role="button">Archive</a>
                        
</div>

 <hr>

<div class="data-table-container">
  <table id="JobListTable" class="cell-border order-column stripe">
        <thead>
        <tr style="background-color: black;color:white;">
            <th>Status</th>
            <th>Date</th>
            <th>Job Number</th>
            <th>Logged by</th>
            <th>Internal / external</th>
            <th>Client name</th>
            <th>Project</th>
            <th>Project management</th>
            <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    </tr>
 </tbody>
    </table>

</div>

<style>
table.dataTable.display tbody tr.status-1.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-1.even > .sorting_1,
table.dataTable.display tbody tr.status-2.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-2.even > .sorting_1,
table.dataTable.display tbody tr.status-3.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-3.even > .sorting_1,
table.dataTable.display tbody tr.status-4.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-4.even > .sorting_1,
table.dataTable.display tbody tr.status-5.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-5.even > .sorting_1,
table.dataTable.display tbody tr.status-6.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-6.even > .sorting_1
{
    background-color: transparent;
}

table.dataTable.display tbody tr.status-1.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-1.odd > .sorting_1,
table.dataTable.display tbody tr.status-2.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-2.odd > .sorting_1,
table.dataTable.display tbody tr.status-3.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-3.odd > .sorting_1,
table.dataTable.display tbody tr.status-4.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-4.odd > .sorting_1,
table.dataTable.display tbody tr.status-5.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-5.odd > .sorting_1,
table.dataTable.display tbody tr.status-6.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-6.odd > .sorting_1
 {
    background-color: transparent;
}

tr.status-1 a,
tr.status-2 a,
tr.status-3 a,
tr.status-6 a,
tr.status-1 a:visited,
tr.status-2 a:visited,
tr.status-3 a:visited,
tr.status-6 a:visited,
tr.status-1 a:hover,
tr.status-2 a:hover,
tr.status-3 a:hover,
tr.status-6 a:hover {
    color: black !important;
}

tr.status-4 a,
tr.status-5 a,
tr.status-4 a:visited,
tr.status-5 a:visited,
tr.status-4 a:hover,
tr.status-5 a:hover {
    color: white !important;
}


</style>
<script>

// Función para actualizar la tabla
function refreshTable() {
            // Llama a la función para cargar los datos en la tabla
            $('#JobListTable').DataTable().ajax.reload(null, false);
 }

function initializeDataTable() {
    loadJobList();
}

function loadJobList() {

    // Recupera el ID de usuario
let userId = localStorage.getItem('user_id');

  let server = window.location.hostname;
  let urlAjax = "https://" + server + "/api/job/get/?type=jobList";
  $("#JobListTable").dataTable({
    keys: true,
    stateSave: true, // Habilitar el guardado del estado
    ajax: {
      url: urlAjax,
      type: "GET",
      dataSrc: "",
      dataType:"json",
                    beforeSend: function (xhr) {
                    // Obtener el token del localStorage
                    let token = localStorage.getItem('token');

                    // Incluir el token en el encabezado de autorización
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    },
    },
    order: [[2, "DESC"]],
    pageLength: 50,
    columns: [
      { data: "status" },
      { data: "date" },
      { data: "job_number" },
      { data: "name" },
      { data: "int_ext" },
      { data: "client_name" },
      { data: "project_name" },
      { data: "project_management" },
    ],

    createdRow: function (row, data, dataIndex) {
    if (data.status === 3) {
        $(row).css('background-color', 'blue');
    }
},

    rowCallback: function(row, data, index) {
      if (data.status == 1) { // OPEN
        $(row).css('background-color', '#EAEAEA')
            .css('color', 'black')
            .addClass('status-' + data.status);
      } else if (data.status == 2) { // QUOTE
        $(row).css('background-color', '#F0D61A')
            .css('color', 'black')
            .addClass('status-' + data.status);
      } else if (data.status == 3) { // QUOTED
        $(row).css('background-color', '#F0981A')
            .css('color', 'black')
            .addClass('status-' + data.status);
      } else if (data.status == 4) { // DEVELOPMENT
        $(row).css('background-color', '#33a854')
            .css('color', 'white')
            .addClass('status-' + data.status);
      } else if (data.status == 5) { // INVOICE
        $(row).css('background-color', '#DD492E')
            .css('color', 'white')
            .addClass('status-' + data.status);
      }
  },
    
    columnDefs: [
      {
    // # PROJECT STATUS
    targets: [0],
    visible: true,
    render: function (data, type, row, meta) {
        // Generate a select element with options for each status
        var selectHTML = '<form id="updateStatus" method="POST" action="" data-id="' + row.id + '">';
        selectHTML += '<input type="hidden" id="id" name="id" value="' + row.id + '">';
        selectHTML += '<select class="form-select statusSelect" style="width: auto;">';
        selectHTML += '<option name="status" value="1"' + (row.status == 1 ? ' selected' : '') + '>Open</option>';
        selectHTML += '<option name="status" value="2"' + (row.status == 2 ? ' selected' : '') + '>Quote</option>';
        selectHTML += '<option name="status" value="3"' + (row.status == 3 ? ' selected' : '') + '>Quoted</option>';
        selectHTML += '<option name="status" value="4"' + (row.status == 4 ? ' selected' : '') + '>Development</option>';
        selectHTML += '<option name="status" value="5"' + (row.status == 5 ? ' selected' : '') + '>Invoice</option>';
         selectHTML += '</select></form>';
        return selectHTML;
    },
},

{
    // # PROJECT STATUS
    targets: [1],
    visible: true,
    render: function (data, type, row, meta) {
        // Generate a select element with options for each status
        if (type === 'display' || type === 'filter') {
            // Formatear la fecha usando moment.js en formato europeo (DD/MM/YYYY)
            return moment(row.date).format('DD/MM/YYYY');
        } else {
            return row.date; // Devuelve los datos sin formato para otros tipos (ordenación, búsqueda, etc.)
        }
    },
},
      {
        // # JOB NUMBER
        // https://datatables.net/examples/advanced_init/column_render.html
        targets: [2],
        visible: true,
        render: function (data, type, row, meta) {
          if (row.job_number == null) {
            return "";
            return '-';
          } else {
            return '<a href="https://' + window.location.hostname + '/job-list/view/' + row.id + '">' + row.job_number + '</a>';
          }
        },
      },

      {
        // # LOGGED BY
        // https://datatables.net/examples/advanced_init/column_render.html
        targets: [3],
        visible: true,
        render: function (data, type, row, meta) {
          if (row.name == null) {
            return ( '-');
          } else {
            return (
              '' +
              row.name.split(' ')[0] +
              ""
            );
          } 
        },
      },

      {
        // # INT / EXT
        // https://datatables.net/examples/advanced_init/column_render.html
        targets: [4],
        visible: true,
        render: function (data, type, row, meta) {
          if (row.int_ext == 1) {
            return (
              'External' + ""
            );
          } else {
            return (
              'Internal' + ""
            );
          } 
        },
      },

      {
        // # CLIENT NAME
        // https://datatables.net/examples/advanced_init/column_render.html
        targets: [5],
        visible: true,
        render: function (data, type, row, meta) {
          if (row.client_name === '') {
            return '<a href="https://' + window.location.hostname + '/client-list/view/' + row.client + '">' + row.business_name + '</a>';
          } else {
            // Genera un enlace con el nombre del cliente y el enlace a su perfil
            return '<a href="https://' + window.location.hostname + '/client-list/view/' + row.client + '">' + row.client_name + ' ( ' + row.business_name + ')</a>';
          } 
        },
      },

      {
        // # PROJECT NAME
        // https://datatables.net/examples/advanced_init/column_render.html
        targets: [6],
        visible: true,
        render: function (data, type, row, meta) {
          return '<strong><a href="https://' + window.location.hostname + '/job-list/view/' + row.id + '">' + row.project_name + '</a</strong>';
          } 
      },

      {
        // # PROJECT MANAGEMENT
        // https://datatables.net/examples/advanced_init/column_render.html
        targets: [7],
        visible: true,
        render: function (data, type, row, meta) {
          let numbers = row.project_management.replace('{', '').replace('}', '').split(',');
          let personsHTML = '';

          numbers.forEach(function(number, index) {
            if (index > 0) {
              personsHTML += ', ';
            }
            let person = persons[number.trim()];
            if (person) {
              personsHTML += `<a href="${person.link}">${person.name}</a>`;
            }
          });

          return personsHTML;
        },
      },

      {
        // # action controller (edit,delete)
        targets: [8],
        orderable: false,
        // # column rendering
        // https://datatables.net/reference/option/columns.render
        render: function (data, type, row, meta) {
          return '<a class="btn btn-sm btn-warning" href="https://'+window.location.hostname+'/job-list/update/'+row.id+'" role="button">Edit</a>';
       
        },
      },

      {
        // # action controller (edit,delete)
        targets: [9],
        orderable: false,
        // # column rendering
        // https://datatables.net/reference/option/columns.render
        render: function (data, type, row, meta) {
            return '<button type="button" onclick="formulariActualizar2(' + userId + ',6, ' + row.id + ', \'/api/job/put/?type=jobStatus\')" class="btn btn-sm btn-danger">Archive</button>';
        },
      },
    ],
  });

 // Registrar el evento de cambio después de la inicialización de la tabla
 $('#JobListTable').on('change', 'select.statusSelect', function() {
    var selectedStatus = $(this).val(); // Obtener el valor del select
    var id = $(this).closest('form').data('id'); // Obtener el ID de la fila del atributo data-id del formulario
    //console.log('Row ID: ' + id); // Imprimir el ID de la fila en la consola
    //console.log('Selected status: ' + selectedStatus);

    // Llamar a la función para actualizar los datos de la tabla
    formulariActualizar2(userId, selectedStatus, id, "/api/job/put/?type=jobStatus");

});

}

 // AJAX PROCESS > PHP API : PER ACTUALIZAR FORMULARIS A LA BD
function formulariActualizar2(user, selected, id, urlAjax) {

// Obtener los datos del formulario como un objeto JSON
var formData = {
    status: selected,
    id: id,
    userId: user
  };
$.ajax({
  contentType: "application/json", // Establecer el tipo de contenido como JSON
  type: "PUT",
  url: urlAjax,
  dataType: "JSON",
  beforeSend: function (xhr) {
    // Obtener el token del localStorage
    let token = localStorage.getItem('token');

    // Incluir el token en el encabezado de autorización
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
  },
  data: JSON.stringify(formData),
  success: function (response) {
    if (response.status == "success") {
      // Add response in Modal body
      $("#updateOk").show();
      $("#updateErr").hide();

    // Recargar la tabla después de actualizar los datos
    $('#JobListTable').DataTable().ajax.reload(null, false);
    } else {
      $("#updateErr").show();
      $("#updateOk").hide();
    }
  },
});
}

let persons = {};

async function fetchUsers() {
  const server = window.location.hostname;
  const apiUrl = `https://${server}/api/users/get/?type=users`;

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

async function initializePersons() {
  const users = await fetchUsers();
  const server = window.location.hostname;
  const url = `https://${server}/job-list/user/`;

  persons = users.reduce((acc, user) => {
    let firstName = user.name.split(' ')[0]; // Obtén el primer nombre
    acc[user.id] = { name: firstName, link: `${url}${user.id}/` };
    return acc;
  }, {});
}

// Llama a initializePersons antes de inicializar la tabla
initializePersons().then(() => {
  initializeDataTable();
});

</script>