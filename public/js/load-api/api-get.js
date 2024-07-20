import { addClient } from '../form-handlers/insert-data.js';
import { convertirAMailto } from '../globals.js';
import {btnDeleteClient} from '../form-handlers/delete-data.js'

window.btnDeleteClient = btnDeleteClient; // Ensure global access

export function clientsList() {
  $(document).ready(function () {
    // Inicializar Select2
    $("#client").select2({
      placeholder: "Select an option",
      allowClear: true,
      width: "resolve", // need to override the changed default
      dropdownCssClass: "bigdrop", // Apply a CSS class for the dropdown
    });

    // Show the add client form when "Add New Client" is selected
    $("#client").on("select2:select", function (e) {
      if (e.params.data.id === "new") {
        $('#modalNewClient').modal('show');
      } else {
        $("#add-client-form").hide();
      }
    });

    // Hide the add client form when another option is selected
    $("#client").on("select2:unselect", function (e) {
      $("#add-client-form").hide();
    });
    // Load data when the page loads
    loadDropdownData();
  });
}
    // Función para cargar datos desde la API
    export function loadDropdownData(clientId = null) {
      $.ajax({
        url:
          "https://" +
          window.location.hostname +
          "/api/clients/get/?type=clients",
        type: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
          // Obtener el token del localStorage
          let token = localStorage.getItem("token");

          // Incluir el token en el encabezado de autorización
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
          // Limpiar el dropdown antes de agregar nuevas opciones
          //$('#client').empty();
          $("#client").append("<option></option>"); // Para permitir el clear

          // Iterate over the data and create new options
          $.each(data, function (index, item) {
            // Append new option with value as the id and text as the business_name
            $("#client").append(new Option(item.business_name, item.id));
          });

          // Actualizar Select2
          if (clientId) {
            $("#client").val(clientId).trigger("change");
          } else {
            $("#client").trigger("change");
          }

          // Llamar a la función addClient
          addClient();
        },
        error: function (xhr, status, error) {

        },
      });
    }


    export function loadTableClients() {

      // Recupera el ID de usuario
    let userId = localStorage.getItem('user_id');
    if (userId) {
        //console.log('User ID:', userId);
        // Utiliza el ID del usuario según tus necesidades
    } else {
        //console.log('User ID not found in localStorage');
    }
    
      let server = window.location.hostname;
      let urlAjax = "https://" + server + "/api/clients/get/?type=clientsList";
      $("#clientsListTable").dataTable({
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
        order: [[2, "asc"]],
        pageLength: 50,
        columns: [
          { data: "client" },
          { data: "client_name" },
          { data: "business_name" },
          { data: "business_address" },
          { data: "email" },
          { data: "phone" },
          { data: "mobile" },
          { data: "vat_number" },
          { data: "po_number" },
          { data: "id" },
          { data: "id" },
        ],
    
        columnDefs: [
    
          {
            // # 1 - CLIENT NAME
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [0],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.id == null) {
                return '<a href="https://' + window.location.hostname + '/client-list/view/' + row.id + '"><i class="bi bi-person-circle"></i></a>';
              } else {
                return '<a href="https://' + window.location.hostname + '/client-list/view/' + row.id + '"><i class="bi bi-person-circle"></i></a>';
              }
            },
          },
    
    
          {
            // # 1 - CLIENT NAME
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [1],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.client_name == null) {
                return "" + row.client_name + " ";
              } else {
                return "" + row.client_name +  "";
              }
            },
          },
    
          {
            // # 2 - BUSINESS NAME
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [2],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.business_name == null) {
                return "";
              } else {
                return "" + row.business_name + " ";
              }
            },
          },
    
          {
            // # 3 - BUSINESS ADDRESS
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [3],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.business_address == null) {
                return (
                  '' +
                  row.business_address +
                  ""
                );
              } else {
                return (
                  '' +
                  row.business_address +
                  ""
                );
              } 
            },
          },
    
          {
        targets: [4], // Índice de la columna que contiene los correos electrónicos
        visible: true,
        render: function (data, type, row, meta) {
            if (row.email == null) {
                return '';
            } else {
                // Llama a la función para convertir los correos electrónicos en enlaces mailto
                return convertirAMailto(row.email);
            }
        }
    },
    
          {
            // # 5 - PHONE
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [5],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.phone == null) {
                return (
                  '' +
                  row.phone +
                  ""
                );
              } else {
                return (
                  '' +
                  row.phone +
                  ""
                );
              } 
            },
          },
    
          {
            // # 6 - MOBILE
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [6],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.mobile == null) {
                return (
                  '' +
                  row.mobile +
                  ""
                );
              } else {
                return (
                  '' +
                  row.mobile +
                  ""
                );
              } 
            },
          },
    
          {
            // # 7 - VAT NUMBER
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [7],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.vat_number == null) {
                return (
                  '' +
                  row.vat_number +
                  ""
                );
              } else {
                return (
                  '' +
                  row.vat_number +
                  ""
                );
              } 
            },
          },
    
          {
            // # 8 - PO NUMBER
            // https://datatables.net/examples/advanced_init/column_render.html
            targets: [8],
            visible: true,
            render: function (data, type, row, meta) {
              if (row.po_number == null) {
                return (
                  '' +
                  row.po_number +
                  ""
                );
              } else {
                return (
                  '' +
                  row.po_number +
                  ""
                );
              } 
            },
          },
    
          
    
          {
        // UPDATE CLIENT
        // # action controller (edit)
        targets: [9],
        orderable: false,
        // # column rendering
        // https://datatables.net/reference/option/columns.render
        render: function (data, type, row, meta) {
          if (userId == 1 || userId == 2 || userId == 4) {
            return '<a class="btn btn-warning" href="https://' + window.location.hostname + '/client-list/update/' + row.id + '" role="button">Update</a>';
        } else {
            return ''; // Devolver una cadena vacía en caso de que no se cumpla la condición
        }
        },
    },
    
    
          {
      // # action controller (edit,delete)
      targets: [10],
      orderable: false,
      // # column rendering
      // https://datatables.net/reference/option/columns.render
      render: function (data, type, row, meta) {
        if (userId == 1 || userId == 2 || userId == 4) {
          return '<button type="button" class="btn btn-danger" onclick="btnDeleteClient(' + row.id + ')">Delete</button>';
        } else {
            return ''; // Devolver una cadena vacía en caso de que no se cumpla la condición
        }
      },
    },
        ],
      });
    }